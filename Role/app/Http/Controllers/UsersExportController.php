<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Excel;


class UsersExportController extends Controller
{  
    private $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }
    public function export() 
    {
        return $this->excel->download(new UsersExport, 'users.xlsx') ;
    }
}
