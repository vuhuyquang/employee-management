<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NhanVienRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ma_nhan_vien' => 'required|min:3|max:15|unique:nhanviens,ma_nhan_vien',
            'ho_ten' => 'required|min:3|max:30',
            'phong_ban_id' => 'required|numeric',
            'password' => 'required|min:6|max:32',
            'email' => 'unique:nhanviens, email|required|max:60|email',
            'ngay_sinh' => 'required|date|before:today',
            'ngay_dau_tien' => 'required|date|before:today',
            'trang_thai' => 'required',
            'anh_dai_dien' => 'mimes:jpeg,jpg,png,gif|required|max:2048',
            'so_dien_thoai' => 'required|max:10|unique:nhanviens,so_dien_thoai'
        ];
    }

    public function messages()
    {
        return [
            'ma_nhan_vien.required' => 'Trường dữ liệu không được để trống',
            'ma_nhan_vien.min' => 'Dữ liệu nhập vào có tối thiểu 3 ký tự',
            'ma_nhan_vien.max' => 'Dữ liệu nhập vào có tối đa 15 ký tự',
            'ma_nhan_vien.unique' => 'Dữ liệu nhập vào không được trùng lặp',
            'ho_ten.required' => 'Trường dữ liệu không được để trống',
            'ho_ten.min' => 'Dữ liệu nhập vào có tối thiểu 3 ký tự',
            'ho_ten.max' => 'Dữ liệu nhập vào có tối đa 30 ký tự',
            'phong_ban_id.required' => 'Trường dữ liệu không được để trống',
            'phong_ban_id.numeric' => 'Dữ liệu nhập vào phải là kiểu số',
            'email.required' => 'Trường dữ liệu không được để trống',
            'email.max' => 'Dữ liệu nhập vào có tối đa 60 ký tự',
            'email.email' => 'Dữ liệu nhập vào phải là dạng email',
            'email.unique' => 'Dữ liệu nhập vào không được trùng lặp',
            'password.required' => 'Trường dữ liệu không được để trống',
            'password.max' => 'Dữ liệu nhập vào có tối đa 32 ký tự',
            'password.min' => 'Dữ liệu nhập vào có tối thiểu 6 ký tự',
            'ngay_sinh.required' => 'Trường dữ liệu không được để trống',
            'ngay_sinh.date' => 'Dữ liệu nhập vào phải là kiểu ngày tháng',
            'ngay_sinh.before' => 'Ngày sinh phải nhỏ hơn ngày hiện tại',
            'ngay_dau_tien.required' => 'Trường dữ liệu không được để trống',
            'ngay_dau_tien.date' => 'Dữ liệu nhập vào phải là kiểu ngày tháng',
            'ngay_dau_tien.before' => 'Ngày đầu tiên đi làm phải nhỏ hơn ngày hiện tại',
            'trang_thai.required' => 'Trường dữ liệu không được để trống',
            'anh_dai_dien.required' => 'Trường dữ liệu không được để trống',
            'anh_dai_dien.mimes' => 'Hình ảnh phải có định đạng jpeg, jpg, png, gif',
            'anh_dai_dien.max' => 'Dữ liệu nhập vào có tối đa 10000 kb',
            'so_dien_thoai.required' => 'Trường dữ liệu không được để trống',
            'so_dien_thoai.max' => 'Dữ liệu nhập vào có tối đa 10 ký tự',
            'so_dien_thoai.unique' => 'Dữ liệu nhập vào không được trùng lặp'
        ];
    }
}
