<?php

namespace App\Imports;

use App\Models\NhanVien;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NhanVienImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new NhanVien([
            'ma_nhan_vien' => $row['ma_nhan_vien'],
            'ho_ten' => $row['ho_ten'],
            'phong_ban_id' => $row['phong_ban_id'],
            'email' => $row['email'],
            'password' => bcrypt($row['password']),
            'ngay_sinh' => $row['ngay_sinh'],
            'ngay_dau_tien' => $row['ngay_dau_tien'],
            'trang_thai' => $row['trang_thai'],
            'anh_dai_dien' => $row['anh_dai_dien'],
            'so_dien_thoai' => $row['so_dien_thoai'],
            'quyen' => $row['quyen'],
        ]);
    }
}
