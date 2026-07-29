<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class About extends BaseController {

    /**
     * Shows the about page
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function index(): string {
        return view('frontend/about');
    }

}
