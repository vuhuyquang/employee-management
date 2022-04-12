<?php

namespace App\Imports;

use App\Models\NhanVien;
use App\Models\PhongBan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithValidation;

class NhanVienImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // $trangthai = $row['trang_thai'] == 'Đang làm việc' ? '1' : '0';
        // $phongban = PhongBan::where('ten', $row['phong_ban'])->first();
        // if ($phongban) {
        //     $phong_ban_id = $phongban->id;
        // } else {
        //     return redirect()->back()->with('error', 'Phòng ban không tồn tại');
        // }

        // $email = NhanVien::where('email', $row['email'])->first();
        // if ($email) {
        //     return redirect()->back()->with('error', 'Email đã tồn tại');
        // } else {
            return new NhanVien([
                'ma_nhan_vien' => $row['ma_nhan_vien'],
                'ho_ten' => $row['ho_ten'],
                'phong_ban_id' => $row['phong_ban_id'],
                'email' => $row['email'],
                'password' => bcrypt($row['password']),
                'ngay_sinh' => $row['ngay_sinh'],
                'ngay_dau_tien' => $row['ngay_dau_tien'],
                'trang_thai' => $row['trangthai'],
                'anh_dai_dien' => $row['anh_dai_dien'],
                'so_dien_thoai' => $row['so_dien_thoai'],
                'quyen' => $row['quyen'],
            ]);   
        // }
    }

    public function rules(): array
    {
        return [
            '*.ma_nhan_vien' => 'bail|required|min:3|max:15|unique:nhanviens,ma_nhan_vien',
            '*.ho_ten' => 'bail|required|min:3|max:30',
            '*.phong_ban_id' => 'required|numeric',
            '*.email' => 'bail|required|max:60|email',
            '*.password' => 'bail|required|min:6|max:32',
            '*.ngay_sinh' => 'required|date|before:today',
            '*.ngay_dau_tien' => 'required|date|before:today',
            '*.trang_thai' => 'required',
            '*.anh_dai_dien' => 'mimes:jpeg,jpg,png,gif|required|max:2048',
            '*.so_dien_thoai' => 'required|max:10|unique:nhanviens,so_dien_thoai',
            '*.quyen' => 'required',
        ];
    }
}
