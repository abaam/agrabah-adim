<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class Report implements FromView, ShouldAutoSize
{
    protected $datas;
    private $type;

    public function __construct($datas, $type)
    {
        $this->datas = $datas;
        $this->type = $type;
    }

    public function view(): View
    {
        return view('wharf.report.export', [
            'row' => $this->datas,
            'type' => $this->type
        ]);
    }
}
