<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index($page = 1): string
    {
        $page = max(1, (int) $page);
        $start = ($page - 1) * 50 + 1;
        $end   = $start + 49;

        return view('frontend/index', [
            'page'  => $page,
            'start' => $start,
            'end'   => $end,
        ]);
    }

    public function cells($page = 1): string
    {
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
