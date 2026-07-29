<?php

namespace App\Controllers\Backend;
use App\Controllers\BaseController;

class Dashboard extends BaseController {
    
    /**
     * Display backend dashboard
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function index(): string {

        $data = [
            'title'          => 'Dashboard',
            'totalAdmins'    => (new \App\Models\AdministratorModel())->countAll(),
            'totalJournals'  => (new \App\Models\JournalModel())->countAll(),
            'totalStamps'    => (new \App\Models\StampModel())->countAll(),
        ];

        return view('backend/layouts/header', $data) . view('backend/dashboard/index') . view('backend/layouts/footer');
    }

    /**
     * Send a test email via configured SMTP (Brevo)
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function testEmail() {

        $webmasterMail = env('email.webmasterMail', '');

        if ($webmasterMail === '') {
            return redirect()->to('admin/dashboard/')->with('error', 'La variable de entorno email.webmasterMail no está configurada.');
        }

        $email = \Config\Services::email();
        $email->setTo($webmasterMail);
        $email->setSubject('[StampCollab] Test de email');
        $email->setMessage(
            '<html><body style="font-family:sans-serif;padding:20px;">'
            . '<h1 style="color:#485fc7;">Test StampCollab</h1>'
            . '<p>Este es un email de prueba enviado desde el panel de administracion.</p>'
            . '<hr><p style="color:#888;font-size:12px;">StampCollab</p>'
            . '</body></html>'
        );

        if ($email->send()) {
            return redirect()->to('admin/dashboard/')->with('success', 'Email de prueba enviado correctamente a ' . $webmasterMail);
        }

        log_message('error', 'Error al enviar email: ' . $email->printDebugger(['headers']));
        return redirect()->to('admin/dashboard/')->with('error', 'Error al enviar el email. Revisa los logs.');
    }
    
}