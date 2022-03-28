<?php

namespace App\Imports;

use App\Models\PhongBan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PhongBanImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PhongBan([
            'ma_phong_ban' => $row['ma_phong_ban'],
            'ten' => $row['ten'],
            'mo_ta' => $row['mo_ta'],
            'truong_phong_id' => $row['truong_phong_id'],
        ]);
    }
}
