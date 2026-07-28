<?php

namespace App\Controllers\Backend;
use App\Controllers\BaseController;

class Auth extends BaseController {

    /**
     * Show backend login form
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function login(): string {
        return view('backend/auth/login');
    }

    /**
     * Try to login into backend
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function attemptLogin() {

        try {

            $email = request()->getPost('email');
            $password = request()->getPost('password');

            $administrator = (new \App\Models\AdministratorModel())->where([ 'email' => $email, 'status' => 1 ])->first();
            if (!$administrator || !password_verify($password, $administrator->password)) { throw new \Exception('Credenciales incorrectas'); }

            $session = session();
            $session->set('administrator', $administrator);
            return response()->setJSON([ 'status'  => true, 'message'  => 'Acceso correcto.', 'redirect' => base_url('admin/dashboard/') ]);

        } catch (\Exception $e) {
            return response()->setJSON([ 'satus' => false, 'message' => $e->getMessage() ]);
        }

        
    }

    /**
     * Logout from backend
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function logout() {
        session()->destroy();
        return redirect()->to('admin/');
    }

}