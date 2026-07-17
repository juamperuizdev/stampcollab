<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Home extends BaseController {

    /**
     * Muestra una página paginada del contenido principal.
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function index(): string {

        return view('frontend/index');

    }

}
