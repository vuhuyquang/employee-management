<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\PhongBan;
use Illuminate\Http\Request;
use Image;
use File;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\NhanVienExport;
use App\Imports\NhanVienImport;
use App\Exports\ManagerEmployeeExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\SendMailResetPassword;
use Illuminate\Support\Str;
use App\Http\Requests\NhanVienRequest;
use Carbon\Carbon;


class NhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phongbans = PhongBan::all();
        $nhanviens = NhanVien::orderBy('id', 'ASC')->search()->paginate(15);
        // dd($nhanviens);

        return view('quantrivien.nhanvien.danhsach', compact('nhanviens', 'phongbans'));
    }

    public function listEmployee()
    {
        $id = Auth::user()->phong_ban_id;
        $nhanviens = NhanVien::where('phong_ban_id', $id)->paginate(15);
        return view('quanly.danhsachphongban', compact('nhanviens'));
    }

    public function date(Request $request)
    {
        $phongbans = PhongBan::all();
        if ($request->bd != null) {
            $nhanviens = NhanVien::orderBy('ngay_sinh', $request->bd)->search()->paginate(15);
            return view('quantrivien.nhanvien.danhsach', compact('nhanviens', 'phongbans'));
        } elseif ($request->fd != null) {
            $nhanviens = NhanVien::orderBy('ngay_dau_tien', $request->fd)->search()->paginate(15);
            return view('quantrivien.nhanvien.danhsach', compact('nhanviens', 'phongbans'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $phongbans = PhongBan::all();
        return view('quantrivien.nhanvien.them', compact('phongbans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(NhanVienRequest $request)
    {
        if ($request->has('anh_dai_dien')) {
            $data = $this->resizeimage($request);
            $tenanh = $data['tenanh'];
            $hinhanh_resize = $data['hinhanh_resize'];
        }

        $nhanvien = new NhanVien;
        $nhanvien->ma_nhan_vien = $request->ma_nhan_vien;
        $nhanvien->ho_ten = $request->ho_ten;
        $nhanvien->phong_ban_id = $request->phong_ban_id;
        $nhanvien->email = $request->email;
        $nhanvien->password = bcrypt($request->password);
        $nhanvien->ngay_sinh = $request->ngay_sinh;
        $nhanvien->ngay_dau_tien = $request->ngay_dau_tien;
        $nhanvien->trang_thai = $request->trang_thai;
        $nhanvien->anh_dai_dien = $tenanh;
        $nhanvien->so_dien_thoai = $request->so_dien_thoai;
        // $nhanvien->quyen = $request->quyen;
        if ($nhanvien->save()) {
            $hinhanh_resize->save(public_path('uploads/' . $tenanh));
            return redirect()->back()->with('success', 'Thêm mới thành công');
        } else {
            return redirect()->back()->with('error', 'Thêm mới thất bại');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NhanVien  $nhanVien
     * @return \Illuminate\Http\Response
     */
    public function show(NhanVien $nhanVien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NhanVien  $nhanVien
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $phongbans = PhongBan::all();
        $nhanvien = NhanVien::findOrFail($id);
        return view('quantrivien.nhanvien.sua', compact('nhanvien', 'phongbans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NhanVien  $nhanVien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ma_nhan_vien' => 'required|min:3|max:15|unique:nhanviens,ma_nhan_vien,' . $id,
            'ho_ten' => 'required|min:3|max:30',
            'phong_ban_id' => 'required|numeric',
            'email' => 'required|max:60|email',
            'ngay_sinh' => 'required|date',
            'ngay_dau_tien' => 'required|date',
            'trang_thai' => 'required',
            'anh_dai_dien' => 'mimes:jpeg,jpg,png,gif|max:2048',
            'so_dien_thoai' => 'required|max:10|unique:nhanviens,so_dien_thoai,' . $id,
            // 'quyen' => 'required'
        ], [
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
            'ngay_sinh.required' => 'Trường dữ liệu không được để trống',
            'ngay_sinh.date' => 'Dữ liệu nhập vào phải là kiểu ngày tháng',
            'ngay_dau_tien.required' => 'Trường dữ liệu không được để trống',
            'ngay_dau_tien.date' => 'Dữ liệu nhập vào phải là kiểu ngày tháng',
            'trang_thai.required' => 'Trường dữ liệu không được để trống',
            'anh_dai_dien.required' => 'Trường dữ liệu không được để trống',
            'anh_dai_dien.mimes' => 'Hình ảnh phải có định đạng jpeg, jpg, png, gif',
            'anh_dai_dien.max' => 'Dữ liệu nhập vào có tối đa 10000 kb',
            'so_dien_thoai.required' => 'Trường dữ liệu không được để trống',
            'so_dien_thoai.max' => 'Dữ liệu nhập vào có tối đa 10 ký tự',
            'so_dien_thoai.unique' => 'Dữ liệu nhập vào không được trùng lặp',
            // 'quyen.required' => 'Trường dữ liệu không được để trống'
        ]);

        $nhanvien = NhanVien::findOrFail($id);
        $nhanvien->ma_nhan_vien = $request->ma_nhan_vien;
        $nhanvien->ho_ten = $request->ho_ten;
        $nhanvien->phong_ban_id = $request->phong_ban_id;
        $nhanvien->email = $request->email;
        $nhanvien->ngay_sinh = $request->ngay_sinh;
        $nhanvien->ngay_dau_tien = $request->ngay_dau_tien;
        $nhanvien->trang_thai = $request->trang_thai;
        $nhanvien->so_dien_thoai = $request->so_dien_thoai;
        if ($request->has('anh_dai_dien')) {
            $data = $this->resizeimage($request);
            $tenanh = $data['tenanh'];
            $hinhanh_resize = $data['hinhanh_resize'];
            $nhanvien->anh_dai_dien = $tenanh;
        }
        // $nhanvien->quyen = $request->quyen;

        if ($request->quyen == 'manager') {
            $phongban = PhongBan::find($request->phong_ban_id);
            if ($phongban->truong_phong_id !== null) {
                return redirect()->back()->with('error', 'Cập nhật thất bại');
            }
        }

        if ($nhanvien->save()) {
            if ($request->has('anh_dai_dien')) {
                $hinhanh_resize->save(public_path('uploads/' . $tenanh));
            }
            return redirect()->back()->with('success', 'Cập nhật thành công');
        } else {
            return redirect()->back()->with('error', 'Cập nhật thất bại');
        }
    }

    public function resizeimage($request)
    {
        $hinhanh = $request->anh_dai_dien;
        $duoianh = $request->anh_dai_dien->extension();
        $tenanh = time() . '.' . $duoianh;

        $hinhanh_resize = Image::make($hinhanh->getRealPath());
        $hinhanh_resize->resize(300, 300);
        // $hinhanh_resize->save(public_path('uploads/' . $tenanh));
        return array('tenanh' => $tenanh, 'hinhanh_resize' => $hinhanh_resize);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NhanVien  $nhanVien
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nhanvien = NhanVien::findOrFail($id);
        $duongdan = public_path('uploads/' . $nhanvien->anh_dai_dien);
        if ($nhanvien->delete()) {
            if (File::exists($duongdan)) {
                unlink($duongdan);
            }
            return redirect()->back()->with('success', 'Xóa thành công');
        } else {
            return redirect()->back()->with('success', 'Xóa thành công');
        }
    }

    public function export()
    {
        return Excel::download(new NhanVienExport, 'EmployeeList.xlsx');
    }

    public function managerExport()
    {
        return Excel::download(new ManagerEmployeeExport, 'EmployeeList.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|max:10000|mimes:xlsx,xls',
        ], [
            'file.required' => 'Trường dữ liệu không được để trống',
            'file.max' => 'Dữ liệu nhập vào có tối đa 10kb',
            'file.mimes' => 'Dữ liệu nhập vào phải là file xlsx, xls',
        ]);
        Excel::import(new NhanVienImport, $request->file);
        return back()->with('success', 'Nhập dữ liệu thành công');
    }

    public function resetPassword($id)
    {
        $password = Str::random(10);
        $nhanvien = NhanVien::findOrFail($id);
        $nhanvien->password = bcrypt($password);
        $nhanvien->lan_dau_tien = 'true';
        if ($nhanvien->save()) {
            $restPasswordJob = new SendMailResetPassword($nhanvien, $password);
            dispatch($restPasswordJob);
            return redirect()->back()->with('success', 'Đã gửi mail đặt lại mật khẩu');
        } else {
            return redirect()->back()->with('error', 'Gửi mail thất bại');
        }
    }
}
