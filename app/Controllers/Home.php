<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Home extends BaseController {

    /**
     * Muestra una página paginada del contenido principal.
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function index($page = 1): string {
        
        $data['page'] = max(1, (int) $page);
        $data['start'] = ($data['page'] - 1) * 50 + 1;
        $data['end'] = $data['page'] + 49;

        return view('frontend/index', $data);
    }

}
