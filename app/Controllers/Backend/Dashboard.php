<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $data = [
            'title'          => 'Dashboard',
            'totalAdmins'    => model('AdministratorModel')->countAll(),
            'totalJournals'  => model('JournalModel')->countAll(),
            'totalStamps'    => model('StampModel')->countAll(),
        ];

        return view('backend/layouts/header', $data)
             . view('backend/dashboard/index')
             . view('backend/layouts/footer');
    }
}
