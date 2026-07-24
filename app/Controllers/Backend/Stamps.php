<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Stamps extends BaseController
{
    protected $model;

    protected function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->model = model('StampModel');
    }

    public function index(): string
    {
        $data = [
            'title'   => 'Stamps',
            'stamps'  => $this->model->orderBy('id', 'ASC')->findAll(),
            'journals' => model('JournalModel')->orderBy('name', 'ASC')->findAll(),
        ];

        return view('backend/layouts/header', $data)
             . view('backend/stamps/index')
             . view('backend/layouts/footer');
    }

    public function new(): string
    {
        $data = [
            'title'    => 'Nuevo stamp',
            'journals' => model('JournalModel')->orderBy('name', 'ASC')->findAll(),
        ];

        return view('backend/layouts/header', $data)
             . view('backend/stamps/form')
             . view('backend/layouts/footer');
    }

    public function create()
    {
        $rules = [
            'id_journal' => 'permit_empty|exists[journal.id]',
            'number'     => 'permit_empty|is_unique[stamp.number]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->save([
            'id_journal' => $this->request->getPost('id_journal') ?: null,
            'number'     => $this->request->getPost('number') ?: null,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/stamps')->with('success', 'Stamp creado.');
    }

    public function edit($id): string
    {
        $data = [
            'title'    => 'Editar stamp',
            'stamp'    => $this->model->find($id),
            'journals' => model('JournalModel')->orderBy('name', 'ASC')->findAll(),
        ];

        return view('backend/layouts/header', $data)
             . view('backend/stamps/form')
             . view('backend/layouts/footer');
    }

    public function update($id)
    {
        $rules = [
            'id_journal' => 'permit_empty|exists[journal.id]',
            'number'     => "permit_empty|is_unique[stamp.number,id,{$id}]",
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->save([
            'id'         => $id,
            'id_journal' => $this->request->getPost('id_journal') ?: null,
            'number'     => $this->request->getPost('number') ?: null,
            'status'     => $this->request->getPost('status') ?? 1,
        ]);

        return redirect()->to('/admin/stamps')->with('success', 'Stamp actualizado.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/stamps')->with('success', 'Stamp eliminado.');
    }
}
