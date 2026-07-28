<?php

namespace App\Controllers\Backend;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Administrators extends BaseController {

    /**
     * List all administrators
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function index(): string {
        $data = [
            'title' => 'Administradores',
            'administrators' => (new \App\Models\AdministratorModel())->orderBy('name', 'ASC')->findAll(),
        ];
        return view('backend/layouts/header', $data) . view('backend/administrators/index') . view('backend/layouts/footer');
    }

    /**
     * Show form to create a new administrator
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function new(): string {
        $data = [ 'title' => 'Nuevo administrador' ];
        return view('backend/layouts/header', $data) . view('backend/administrators/form') . view('backend/layouts/footer');
    }

    /**
     * Show form to edit an administrator
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function edit(int $id): string {
        $data = [
            'title' => 'Editar administrador',
            'administrator' => (new \App\Models\AdministratorModel())->where('id', $id)->first(),
        ];
        return view('backend/layouts/header', $data) . view('backend/administrators/form') . view('backend/layouts/footer');
    }

    /**
     * Create a new administrator
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function create() {

        $rules = [
            'name'     => 'required|max_length[100]',
            'surname'  => 'required|max_length[100]',
            'email'    => 'required|valid_email|is_unique[administrator.email]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new \App\Models\AdministratorModel())->save([
            'name'     => request()->getPost('name'),
            'surname'  => request()->getPost('surname'),
            'email'    => request()->getPost('email'),
            'password' => password_hash(request()->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('admin/administrators/')->with('success', 'Administrador creado');
    }

    /**
     * Update an administrator
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function update(int $id) {
        
        $rules = [
            'name'    => 'required|max_length[100]',
            'surname' => 'required|max_length[100]',
            'email'   => "required|valid_email|is_unique[administrator.email,id,{$id}]",
        ];

        if (!$this->validate($rules)) { return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()); }

        $fields = [
            'id' => $id,
            'name' => request()->getPost('name'),
            'surname' => request()->getPost('surname'),
            'email' => request()->getPost('email'),
        ];

        $password = request()->getPost('password');
        if (!empty($password)) { $fields['password'] = password_hash($password, PASSWORD_DEFAULT); }

        (new \App\Models\AdministratorModel())->save($fields);
        return redirect()->to('admin/administrators/')->with('success', 'Administrador actualizado');
    }

    /**
     * Toggle administrator status
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function toggleStatus(int $id): ResponseInterface {
        
        $admin = (new \App\Models\AdministratorModel())->where('id', $id)->first();
        if (! $admin) { return $this->response->setJSON(['success' => false, 'message' => 'Administrador no encontrado.']);}

        $newStatus = $admin->status ? 0 : 1;
        (new \App\Models\AdministratorModel())->save([ 'id' => $id, 'status' => $newStatus ]);

        return $this->response->setJSON([
            'success' => true,
            'status'  => $newStatus,
            'label'   => $newStatus ? 'Activo' : 'Inactivo',
        ]);
    }

    /**
     * Delete an administrator
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function delete(int $id) {
        (new \App\Models\AdministratorModel())->delete($id);
        return redirect()->to('admin/administrators/')->with('success', 'Administrador eliminado');
    }

}