<?php

namespace App\Controllers\Backend;
use App\Controllers\BaseController;

class Stamps extends BaseController {

    /**
     * Display a listing of stamps
     * @author Juampe Ruiz
     * @version 1.0
     */    
    public function index(): string {
        $data = [
            'title'   => 'Stamps',
            'stamps'  => (new \App\Models\StampModel())->orderBy('id', 'DESC')->findAll(),
            'journals' => (new \App\Models\JournalModel())->orderBy('name', 'ASC')->findAll(),
        ];

        return view('backend/layouts/header', $data) . view('backend/stamps/index') . view('backend/layouts/footer');
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

        $rules = [
            'id_journal' => 'permit_empty|exists[journal.id]',
            'number'     => 'permit_empty|is_unique[stamp.number]',
        ];

        if (!$this->validate($rules)) { return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()); }

        (new \App\Models\StampModel())->save([
            'id_journal' => $this->request->getPost('id_journal') ?: null,
            'number'     => $this->request->getPost('number') ?: null,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('admin/stamps/')->with('success', 'Stamp creado');
    }

    /**
     * Update a stamp
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function update(int $id) {

        $rules = [
            'id_journal' => 'permit_empty|exists[journal.id]',
            'number'     => "permit_empty|is_unique[stamp.number,id,{$id}]",
        ];

        if (!$this->validate($rules)) { return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()); }

        (new \App\Models\StampModel())->save([
            'id'         => $id,
            'id_journal' => $this->request->getPost('id_journal') ?: null,
            'number'     => $this->request->getPost('number') ?: null,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('admin/stamps/')->with('success', 'Stamp actualizado');
    }

    public function delete(int $id) {
        (new \App\Models\StampModel())->delete($id);
        return redirect()->to('admin/stamps/')->with('success', 'Stamp eliminado');
    }

}