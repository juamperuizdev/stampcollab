<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Page extends BaseController {

    public function getPage($page = 1): string {
        
    $page = max(1, (int) $page);
        $start = ($page - 1) * 50 + 1;
        $end   = $start + 49;

        return view('partials/cells', [
            'page'  => $page,
            'start' => $start,
            'end'   => $end,
        ]);
        
    }

}