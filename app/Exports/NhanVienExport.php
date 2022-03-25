<?php

namespace App\Exports;

use App\Models\NhanVien;
use Maatwebsite\Excel\Concerns\FromCollection;


class NhanVienExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return NhanVien::all();
    }
}
