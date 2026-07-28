<?php

namespace App\Controllers\Backend;
use App\Controllers\BaseController;

class Journals extends BaseController {

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

        (new \App\Models\JournalModel())->save([
            'slug'        => mb_url_title($this->request->getPost('name'), '-', true),
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status') ?? 'HIDDEN',
        ]);

        return redirect()->to('admin/journals/')->with('success', 'Journal creado');
    }
    
    /**
     * Update a journal
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function update(int $id) {
        $rules = [
            'slug' => "required|alpha_dash|is_unique[journal.slug,id,{$id}]",
            'name' => 'required|max_length[100]',
        ];

        if (!$this->validate($rules)) { return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()); }

        (new \App\Models\JournalModel())->save([
            'id'          => $id,
            'slug'        => mb_url_title($this->request->getPost('name'), '-', true),
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status') ?? 'HIDDEN',
        ]);

        return redirect()->to('admin/journals/')->with('success', 'Journal actualizado');
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

}