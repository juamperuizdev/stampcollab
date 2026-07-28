<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JournalModel;
use App\Models\StampModel;

class Page extends BaseController {

    public string $uploadFolder = 'public/uploads/journals/';

    /**
     * Get the page of the journal in frontend by ajax petition
     * @author Juampe Ruiz
     * @version 1.0
     */
    public function getPage($page = 1, $journalId = null): ResponseInterface {

        $page = max(1, (int) $page);
        $stamps = [];
        $journal = (new JournalModel())->where('id', $journalId)->first();

        if ($journal && $journal->pages > 0) {

            $perSpread = (int) ceil($journal->stamps / $journal->pages);
            $perSide   = (int) ceil($perSpread / 2);

            $start = ($page - 1) * $perSpread + 1;
            $end   = min($start + $perSpread - 1, $journal->stamps);

            $dbStamps = (new StampModel())
                ->where('id_journal', $journal->id)
                ->where('number >=', $start)
                ->where('number <=', $end)
                ->findAll();

            foreach ($dbStamps as $s) {
                if ($s->image) {
                    $stamps[] = [
                        'number'    => $s->number,
                        'thumb_url' => base_url($this->uploadFolder . $journal->id . '/thumbs/' . $s->image),
                        'full_url'  => base_url($this->uploadFolder . $journal->id . '/' . $s->image),
                    ];
                }
            }

        } else {

            $perSide = 0;
            $start   = 1;
            $end     = 0;
            
        }

        return response()->setJSON([
            'page'   => $page,
            'start'  => $start,
            'end'    => $end,
            'per_side' => $perSide,
            'pages'  => $journal ? (int) $journal->pages : 0,
            'stamps_total' => $journal ? (int) $journal->stamps : 0,
            'stamps' => $stamps,
            'journal_id' => $journal ? $journal->id : null,
            'upload_url' => base_url('upload/stamp'),
            'allowed_formats' => STAMP_ALLOWED_FORMATS,
            'crop_ratio' => ['w' => 21, 'h' => 25],
        ]);

    }

}