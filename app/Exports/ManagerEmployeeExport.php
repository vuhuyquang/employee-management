<?php

namespace App\Exports;

use App\Models\NhanVien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;

class ManagerEmployeeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return NhanVien::where('phong_ban_id', '=', Auth::user()->phong_ban_id)->get();
    }
}
