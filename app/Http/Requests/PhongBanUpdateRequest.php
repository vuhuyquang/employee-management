<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhongBanUpdateRequest extends FormRequest
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
            'ma_phong_ban' => 'required|min:3|max:15|unique:phongbans,ma_phong_ban,' . $id,
            'ten' => 'required|min:3|max:50|unique:phongbans,ten,' . $id,
            'mo_ta' => 'max:254',
            'truong_phong_id' => 'unique:phongbans,truong_phong_id,' . $id
        ];
    }

    public function messages()
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
