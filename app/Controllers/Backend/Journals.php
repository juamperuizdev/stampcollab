<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Journals extends BaseController
{
    protected $model;

    protected function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->model = model('JournalModel');
    }

    public function index(): string
    {
        $data = [
            'title'    => 'Journals',
            'journals' => $this->model->orderBy('id', 'ASC')->findAll(),
        ];

        return view('backend/layouts/header', $data)
             . view('backend/journals/index')
             . view('backend/layouts/footer');
    }

    public function new(): string
    {
        $data = [
            'title' => 'Nuevo journal',
        ];

        return view('backend/layouts/header', $data)
             . view('backend/journals/form')
             . view('backend/layouts/footer');
    }

    public function create()
    {
        $rules = [
            'slug' => 'required|alpha_dash|is_unique[journal.slug]',
            'name' => 'required|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->save([
            'slug'        => $this->request->getPost('slug'),
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status') ?? 'HIDDEN',
        ]);

        return redirect()->to('/admin/journals')->with('success', 'Journal creado.');
    }

    public function edit($id): string
    {
        $data = [
            'title'   => 'Editar journal',
            'journal' => $this->model->find($id),
        ];

        return view('backend/layouts/header', $data)
             . view('backend/journals/form')
             . view('backend/layouts/footer');
    }

    public function update($id)
    {
        $rules = [
            'slug' => "required|alpha_dash|is_unique[journal.slug,id,{$id}]",
            'name' => 'required|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->save([
            'id'          => $id,
            'slug'        => $this->request->getPost('slug'),
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status') ?? 'HIDDEN',
        ]);

        return redirect()->to('/admin/journals')->with('success', 'Journal actualizado.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/journals')->with('success', 'Journal eliminado.');
    }
}
