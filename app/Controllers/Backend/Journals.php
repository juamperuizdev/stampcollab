<?php

namespace App\Controllers\Backend;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Journals extends BaseController {

    public string $uploadFolder = 'public/uploads/journals/';

    /**
     * Display a listing of journals
     * @author Juampe Ruiz
     */
    public function index(): string {
        $data = [
            'title'    => 'Journals',
            'journals' => (new \App\Models\JournalModel())->orderBy('id', 'DESC')->findAll(),
        ];
        return view('backend/layouts/header', $data) . view('backend/journals/index') . view('backend/layouts/footer');
    }

    /**
     * Show the form for creating a new journal
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function new(): string {
        $data = ['title' => 'Nuevo journal'];
        return view('backend/layouts/header', $data) . view('backend/journals/form') . view('backend/layouts/footer');
    }

    /**
     * Show the form for editing a journal
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function edit(int $id): string {
        $data = [
            'title'   => 'Editar journal',
            'journal' => (new \App\Models\JournalModel())->where('id', $id)->first()
        ];
        return view('backend/layouts/header', $data) . view('backend/journals/form') . view('backend/layouts/footer');
    }

    /**
     * Create a new journal
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function create() {

        $rules = [
            'name' => 'required|max_length[100]',
        ];

        if (!$this->validate($rules)) { return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()); }

        $model = new \App\Models\JournalModel();
        $model->save([
            'slug'        => mb_url_title(request()->getPost('name'), '-', true),
            'name'        => request()->getPost('name'),
            'description' => request()->getPost('description'),
            'status'      => request()->getPost('status') ?? 'HIDDEN',
            'pages'       => request()->getPost('pages') ?? 0,
            'stamps'      => request()->getPost('stamps') ?? 0,
            'cover'       => request()->getPost('cover'),
        ]);

        $this->moveCover($model->insertID());

        return redirect()->to('admin/journals/')->with('success', 'Journal creado');
    }
    
    /**
     * Update a journal
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function update(int $id) {

        $rules = [
            'name' => 'required|max_length[100]',
        ];

        if (!$this->validate($rules)) { return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()); }

        $data = [
            'id'          => $id,
            'slug'        => mb_url_title(request()->getPost('name'), '-', true),
            'name'        => request()->getPost('name'),
            'description' => request()->getPost('description'),
            'status'      => request()->getPost('status') ?? 'HIDDEN',
            'pages'       => request()->getPost('pages') ?? 0,
            'stamps'      => request()->getPost('stamps') ?? 0,
        ];

        $cover = request()->getPost('cover');
        if ($cover) { $data['cover'] = $cover; }

        (new \App\Models\JournalModel())->save($data);
        $this->moveCover($id);
        return redirect()->to('admin/journals/')->with('success', 'Journal actualizado');

    }

    /**
     * Upload a cover to a journal
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function uploadCover(): ResponseInterface {

        try {

            $file = request()->getFile('cover');
            if (!$file || !$file->isValid()) {throw new \Exception('No se recibió ninguna imagen válida'); }
            if (!in_array($file->getMimeType(), STAMP_ALLOWED_FORMATS)) { throw new \Exception('Formato de imagen no permitido'); }

            $uploadPath = ROOTPATH . 'public/uploads/tmp';
            if (! is_dir($uploadPath)) { mkdir($uploadPath, 0755, true); }

            $filename = $file->getRandomName();
            $file->move($uploadPath, $filename);

            return response()->setJSON([
                'success'  => true,
                'filename' => $filename,
            ]);

        } catch (\Exception $e) {
            return response()->setJSON([ 'success' => false, 'message' => $e->getMessage() ]);
            
        }
        
    }

    /**
     * Delete the cover of a journal
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function deleteCover(int $id) : ResponseInterface {

        $journal = (new \App\Models\JournalModel())->where('id', $id)->first();
        if (!$journal || !$journal->cover) { return response()->setJSON(['success' => false, 'message' => 'No hay portada que eliminar']); }

        $filePath = ROOTPATH . 'public/uploads/' . $id . '/' . $journal->cover;
        if (file_exists($filePath)) { unlink($filePath); }

        (new \App\Models\JournalModel())->save([
            'id'    => $id,
            'cover' => null,
        ]);

        return response()->setJSON(['success' => true]);
    }

    /**
     * Delete a journal
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function delete(int $id) {
        (new \App\Models\JournalModel())->delete($id);
        return redirect()->to('admin/journals/')->with('success', 'Journal eliminado');
    }

    /**
     * Move the cover to the journal folder
     * @author Juampe Ruiz
     * @version 1.0
     */
    private function moveCover(int $id): void {

        $tmpFilename = request()->getPost('cover');
        if (!$tmpFilename) return;

        $tmpPath = ROOTPATH . 'public/uploads/tmp/' . $tmpFilename;
        if (!file_exists($tmpPath)) return;

        $destDir = ROOTPATH . $this->uploadFolder . $id;
        if (!is_dir($destDir)) { mkdir($destDir, 0755, true); }

        $destPath = $destDir . '/cover.webp';
        rename($tmpPath, $destPath);

        (new \App\Models\JournalModel())->save([
            'id'    => $id,
            'cover' => 'cover.webp',
        ]);
    }

}