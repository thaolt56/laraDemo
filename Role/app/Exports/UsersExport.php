<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Role;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class UsersExport implements 
    FromCollection, 
    ShouldAutoSize,
     WithMapping,
     WithHeadings,
     WithDrawings
{   
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
   
    // private $fileName = "users.xlsx";
   
    public function collection()
    {
        return User::all();
    }
    public function map($user):array{
        return [
            $user->id,
            $user->name,
            $user->email,
            // $user->roles->name,
            $user->created_at

        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Email',
            'Date'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class  => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:D1')->applyFromArray([
                    'font' =>[
                        'bold' => true
                    ]
                ]);
                
            },

           
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/image/laravel.png'));
        $drawing->setHeight(100);
        $drawing->setCoordinates('E2');

       
        return [$drawing];
    }

}
