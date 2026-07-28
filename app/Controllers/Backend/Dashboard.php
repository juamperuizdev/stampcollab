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
    
}