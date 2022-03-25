<?php

namespace App\Imports;

use App\Models\PhongBan;
use Maatwebsite\Excel\Concerns\ToModel;

class PhongBanImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PhongBan([
            'ma_phong_ban' => $row[1],
            'ten' => $row[2],
            'mo_ta' => $row[3],
            'truong_phong_id' => $row[4],
        ]);
    }
}
