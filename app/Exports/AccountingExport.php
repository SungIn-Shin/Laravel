<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

use App\Document;



class AccountingExport implements FromQuery
{
    use Exportable;

    public function query()
    {
        return Document::all();
    }


}
