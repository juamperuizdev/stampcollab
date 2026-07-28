<?php

namespace App\Controllers\Backend;
use App\Controllers\BaseController;

class Stamps extends BaseController {

    private string $uploadFolder = 'public/uploads/journals/';

    private function validateNumber(int $id_journal, ?int $number, ?int $excludeId = null): ?string
    {
        if ($number === null || $number === 0) {
            return null;
        }

        if ($number < 1) {
            return 'El número debe ser un entero mayor que 0.';
        }

        $model = new \App\Models\StampModel();
        $model->where('id_journal', $id_journal)->where('number', $number);

        if ($excludeId !== null) {
            $model->where('id !=', $excludeId);
        }

        if ($model->first()) {
            return 'Ya existe un sello con ese número en este journal.';
        }

        return null;
    }

    private function renameImageFiles(int $id_journal, string $oldName, string $newName): void
    {
        $basePath = ROOTPATH . $this->uploadFolder . $id_journal . '/';

        $oldImage = $basePath . $oldName;
        $newImage = $basePath . $newName;
        if (file_exists($oldImage)) {
            rename($oldImage, $newImage);
        }

        $oldThumb = $basePath . 'thumbs/' . $oldName;
        $newThumb = $basePath . 'thumbs/' . $newName;
        if (file_exists($oldThumb)) {
            rename($oldThumb, $newThumb);
        }
    }

    /**
     * Display a listing of stamps
     * @author Juampe Ruiz
     * @version 1.0
     */    
    public function index(): string {

        $lastJournal = (new \App\Models\JournalModel())->orderBy('id', 'DESC')->first();
        $journalId   = $lastJournal ? $lastJournal->id : 0;

        $data = [
            'title'    => 'Stamps',
            'stamps'   => (new \App\Models\StampModel())->where('id_journal', $journalId)->orderBy('number', 'ASC')->findAll(),
            'journals' => (new \App\Models\JournalModel())->orderBy('id', 'DESC')->findAll(),
            'selected' => $journalId,
        ];

        return view('backend/layouts/header', $data) . view('backend/stamps/index') . view('backend/layouts/footer');
    }

    public function byJournal(int $id) {
        $stamps = (new \App\Models\StampModel())->where('id_journal', $id)->orderBy('number', 'ASC')->findAll();

        $html = '';
        foreach ($stamps as $stamp) {
            $imageUrl = $stamp->image ? base_url('public/uploads/journals/' . $stamp->id_journal . '/thumbs/' . $stamp->image) : base_url('public/assets/image/stamp.png');
            $statusClass = $stamp->status ? 'is-success' : 'is-danger';
            $statusLabel = $stamp->status ? 'Activo' : 'Inactivo';

            $html .= '<div class="column is-1">';
            $html .= '<div class="box has-text-centered" style="padding:0.75rem;position:relative">';
            $html .= '<a href="' . base_url("admin/stamps/{$stamp->id}/edit/") . '">';
            $html .= '<img src="' . $imageUrl . '" alt="Stamp" style="width:100%;aspect-ratio:21/25;object-fit:contain;display:block">';
            $html .= '</a>';
            $html .= '<span class="tag is-light is-small" style="position:absolute;top:0.5rem;right:0.5rem">#' . ($stamp->number ?? '?') . '</span>';
            $html .= '<p class="mt-2"><span class="tag ' . $statusClass . '">' . $statusLabel . '</span></p>';
            $html .= '<div class="buttons is-centered mt-2" style="gap:0.25rem">';
            $html .= '<a href="' . base_url("admin/stamps/{$stamp->id}/edit/") . '" class="button is-small is-dark"><span class="icon"><i class="fa-solid fa-pen"></i></span></a>';
            $html .= '<form method="POST" action="' . base_url("admin/stamps/{$stamp->id}") . '" class="is-inline-block" onsubmit="return confirm(\'¿Eliminar este stamp?\')"><input type="hidden" name="_method" value="DELETE"><button class="button is-small is-danger"><span class="icon"><i class="fa-solid fa-trash"></i></span></button></form>';
            $html .= '</div></div></div>';
        }

        if (empty($stamps)) {
            $html = '<div class="column"><p class="has-text-centered has-text-grey">No hay stamps en este journal</p></div>';
        }

        return $this->response->setJSON(['html' => $html]);
    }

    /**
     * Show the form for creating a new stamp
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function new(): string {

        $data = [
            'title'    => 'Nuevo stamp',
            'journals' => (new \App\Models\JournalModel())->orderBy('name', 'ASC')->findAll(),
        ];

        return view('backend/layouts/header', $data) . view('backend/stamps/form') . view('backend/layouts/footer');
    }

    /**
     * Show the form for editing a stamp
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function edit(int $id): string {

        $data = [
            'title'    => 'Editar stamp',
            'stamp'    => (new \App\Models\StampModel())->where('id', $id)->first(),
            'journals' => (new \App\Models\JournalModel())->orderBy('name', 'ASC')->findAll(),
        ];

        return view('backend/layouts/header', $data) . view('backend/stamps/form') . view('backend/layouts/footer');
    }

    /**
     * Create a new stamp
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function create() {

        $id_journal = $this->request->getPost('id_journal') ?: null;
        $number     = $this->request->getPost('number') ? ($this->request->getPost('number') !== '' ? (int) $this->request->getPost('number') : null) : null;

        $numberError = $this->validateNumber($id_journal, $number);
        if ($numberError) {
            return redirect()->back()->withInput()->with('errors', [$numberError]);
        }

        (new \App\Models\StampModel())->save([
            'id_journal' => $id_journal,
            'number'     => $number,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('admin/stamps/')->with('success', 'Stamp creado');
    }

    public function update(int $id) {

        $id_journal = $this->request->getPost('id_journal') ?: null;
        $number     = $this->request->getPost('number') ? ($this->request->getPost('number') !== '' ? (int) $this->request->getPost('number') : null) : null;

        $numberError = $this->validateNumber($id_journal, $number, $id);
        if ($numberError) {
            return redirect()->back()->withInput()->with('errors', [$numberError]);
        }

        $stamp = (new \App\Models\StampModel())->find($id);

        $data = [
            'id'         => $id,
            'id_journal' => $id_journal,
            'number'     => $number,
            'status'     => $this->request->getPost('status') ?? 1,
        ];

        (new \App\Models\StampModel())->save($data);

        if ($stamp && $stamp->image && $number && $number !== (int) $stamp->number) {
            $ext = pathinfo($stamp->image, PATHINFO_EXTENSION);
            $newName = $number . '.' . $ext;
            $this->renameImageFiles($id_journal, $stamp->image, $newName);

            (new \App\Models\StampModel())->save([
                'id'    => $id,
                'image' => $newName,
            ]);
        }

        return redirect()->to('admin/stamps/')->with('success', 'Stamp actualizado');
    }

    public function delete(int $id) {
        (new \App\Models\StampModel())->delete($id);
        return redirect()->to('admin/stamps/')->with('success', 'Stamp eliminado');
    }

}