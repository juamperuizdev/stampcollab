<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Home extends BaseController {

    /**
     * Shows the home page in frontend
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function index(): string {

        // Get the last journal
        $data['journal'] = (new \App\Models\JournalModel())->where([ 'status' => 'STARTED' ])->orderBy('id DESC')->first();
        return view('frontend/index', $data);

    }

}