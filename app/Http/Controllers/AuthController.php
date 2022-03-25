<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use Image;
use File;
use App\Models\NhanVien;
use App\Models\PhongBan;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('dangnhap');
    }

    public function postLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email|max:30',
                'password' => 'required|min:6|max:32',
            ],
            [
                'email.required' => 'Trường dữ liệu không được để trống',
                'email.email' => 'Dữ liệu nhập vào phải là kiểu email',
                'email.max' => 'Dữ liệu nhập có tối đa 30 ký tự',
                'password.required' => 'Trường dữ liệu không được để trống',
                'password.min' => 'Dữ liệu nhập có tối thiểu 6 ký tự',
                'password.max' => 'Dữ liệu nhập có tối đa 32 ký tự',
            ]
        );

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('redirect');
        } else {
            return redirect()->back()->with('thongbao', 'Tài khoản hoặc mật khẩu không chính xác');
        }
    }

    public function redirect()
    {
        if (Auth::user()->quyen == 'admin') {
            return redirect()->route('employee.index');
        } elseif(Auth::user()->quyen == 'manager') {
            return redirect()->route('list.employee');
        } elseif(Auth::user()->quyen == 'employee') {
            return redirect()->route('getProfile');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('getLogin');
    }

    public function getChangePassword()
    {
        return view('doimatkhau');
    }

    public function postChangePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => 'required|min:6|max:32',
            'newPassword' => 'required|min:6|max:32',
            'reNewPassword' => 'required|min:6|max:32|same:newPassword'
        ], [
            'oldPassword.required' => 'Trường dữ liệu không được để trống',
            'oldPassword.max' => 'Dữ liệu nhập vào có tối đa 32 ký tự',
            'oldPassword.min' => 'Dữ liệu nhập vào có tối thiểu 6 ký tự',
            'newPassword.required' => 'Trường dữ liệu không được để trống',
            'newPassword.max' => 'Dữ liệu nhập vào có tối đa 32 ký tự',
            'newPassword.min' => 'Dữ liệu nhập vào có tối thiểu 6 ký tự',
            'reNewPassword.required' => 'Trường dữ liệu không được để trống',
            'reNewPassword.max' => 'Dữ liệu nhập vào có tối đa 32 ký tự',
            'reNewPassword.min' => 'Dữ liệu nhập vào có tối thiểu 6 ký tự',
            'reNewPassword.same' => 'Xác nhận mật khẩu không trùng khớp'
        ]);

        $nhanvien = Auth::user();
        $password = $nhanvien->password;
        if (Hash::check($request->oldPassword, $password)) {
            $nhanvien->password = Hash::make($request->newPassword);
            if ($nhanvien->save()) {
                return redirect()->back()->with('success', 'Đổi mật khẩu thành công');
            } else {
                return redirect()->back()->with('error', 'Đổi mật khẩu thất bại');
            }
        } else {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không chính xác');
        }
    }

    public function getProfile()
    {
        if (Auth::check()) {
            $nhanvien = NhanVien::findOrFail(Auth::user()->id);
        } else {
            return redirect()->back();
        }
        $phongbans = PhongBan::all();
        $nhanvien = NhanVien::findOrFail(Auth::user()->id);
        return view('hosocanhan', compact('nhanvien', 'phongbans'));
    }

    public function postProfile(Request $request)
    {
        $id = Auth::user()->id;
    
        $request->validate([
            'ngay_sinh' => 'required|date',
            'anh_dai_dien' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
            'so_dien_thoai' => 'max:10|unique:nhanviens,so_dien_thoai,' . $id
        ], [
            'ngay_sinh.required' => 'Trường dữ liệu không được để trống',
            'ngay_sinh.date' => 'Dữ liệu nhập vào phải là kiểu ngày tháng',
            'anh_dai_dien.required' => 'Trường dữ liệu không được để trống',
            'anh_dai_dien.mimes' => 'Hình ảnh phải có định đạng jpeg, jpg, png, gif',
            'anh_dai_dien.max' => 'Dữ liệu nhập vào có tối đa 10000 kb',
            'so_dien_thoai.max' => 'Dữ liệu nhập vào có tối đa 10 ký tự',
            'so_dien_thoai.unique' => 'Dữ liệu nhập vào không được trùng lặp'
        ]);

        if ($request->has('anh_dai_dien')) {
            $data = $this->resizeimage($request);
            $tenanh = $data['tenanh'];
            $hinhanh_resize = $data['hinhanh_resize'];
        }

        $nhanvien = NhanVien::findOrFail(Auth::user()->id);
        $nhanvien->ma_nhan_vien = $request->ma_nhan_vien;
        $nhanvien->ho_ten = $request->ho_ten;
        $nhanvien->phong_ban_id = $request->phong_ban_id;
        $nhanvien->email = $request->email;
        $nhanvien->ngay_sinh = $request->ngay_sinh;
        $nhanvien->ngay_dau_tien = $request->ngay_dau_tien;
        $nhanvien->trang_thai = $request->trang_thai;
        $nhanvien->anh_dai_dien = $tenanh;
        $nhanvien->so_dien_thoai = $request->so_dien_thoai;

        if ($nhanvien->save()) {
            $hinhanh_resize->save(public_path('uploads/' . $tenanh));
            return redirect()->back()->with('success', 'Cập nhật thành công');
        } else {
            return redirect()->back()->with('error', 'Cập nhật thất bại');
        }
    }

    public function resizeimage($request)
    {
        $hinhanh = $request->anh_dai_dien;
        $duoianh = $request->anh_dai_dien->getClientOriginalExtension();
        $tenanh = time() . '.' . $duoianh;

        $hinhanh_resize = Image::make($hinhanh->getRealPath());
        $hinhanh_resize->resize(300, 300);
        // $hinhanh_resize->save(public_path('uploads/' . $tenanh));
        return array('tenanh' => $tenanh, 'hinhanh_resize' => $hinhanh_resize);
    }

    public function home()
    {
        return view('trangchu');
    }
}
