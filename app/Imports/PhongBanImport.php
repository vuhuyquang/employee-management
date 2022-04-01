<?php

namespace App\Imports;

use App\Models\PhongBan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PhongBanImport implements ToModel, WithHeadingRow, WithValidation
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

    public function rules(): array
    {
        return [
            '*.ma_phong_ban' => ['ma_phong_ban', 'required|min:3|max:15|unique:phongbans,ma_phong_ban'],
            '*.ten' => ['ten', 'required|min:3|max:50|unique:phongbans,ten'],
            '*.mo_ta' => ['mo_ta', 'max:254'],
            '*.truong_phong_id' => ['truong_phong_id', 'unique:phongbans,truong_phong_id']
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_phong_ban.required' => 'Trường dữ liệu không được để trống',
            'ma_phong_ban.min' => 'Dữ liệu nhập vào phải có tối thiểu 3 ký tự',
            'ma_phong_ban.max' => 'Dữ liệu nhập vào phải có tối đa 15 ký tự',
            'ma_phong_ban.unique' => 'Dữ liệu nhập vào không được trùng lặp',
            'ten.required' => 'Trường dữ liệu không được để trống',
            'ten.min' => 'Dữ liệu nhập vào phải có tối thiểu 3 ký tự',
            'ten.max' => 'Dữ liệu nhập vào phải có tối đa 50 ký tự',
            'ten.unique' => 'Dữ liệu nhập vào không được trùng lặp',
            'ten.max' => 'Dữ liệu nhập vào phải có tối đa 254 ký tự',
            'truong_phong_id.unique' => 'Dữ liệu nhập vào không được trùng lặp'
        ];
    }
}
