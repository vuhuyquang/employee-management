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
        switch ($request->day) {
            case '1':
                $nhanviens = NhanVien::orderBy('ngay_sinh', 'ASC')->search()->paginate(15);
                return view('quantrivien.nhanvien.danhsach', compact('nhanviens', 'phongbans'));
                break;
            case '2':
                $nhanviens = NhanVien::orderBy('ngay_sinh', 'DESC')->search()->paginate(15);
                return view('quantrivien.nhanvien.danhsach', compact('nhanviens', 'phongbans'));
                break;
            case '3':
                $nhanviens = NhanVien::orderBy('ngay_dau_tien', 'ASC')->search()->paginate(15);
                return view('quantrivien.nhanvien.danhsach', compact('nhanviens', 'phongbans'));
                break; 
            case '4':
                $nhanviens = NhanVien::orderBy('ngay_dau_tien', 'DESC')->search()->paginate(15);
                return view('quantrivien.nhanvien.danhsach', compact('nhanviens', 'phongbans'));
                break;    
            default:
                return redirect()->back()->with('error', 'Gi?? tr??? kh??ng h???p l???');
                break;
        }
    }

    public function filter(Request $request)
    {
        $phongbans = PhongBan::all();
        $nhanviens = NhanVien::Search($request)->paginate(15);
        return view('quantrivien.nhanvien.danhsach', compact('nhanviens', 'phongbans'));
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
            return redirect()->back()->with('success', 'Th??m m???i th??nh c??ng');
        } else {
            return redirect()->back()->with('error', 'Th??m m???i th???t b???i');
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
            'email' => 'required|max:60|email|unique:nhanviens,email,'. $id,
            'ngay_sinh' => 'required|date',
            'ngay_dau_tien' => 'required|date',
            'trang_thai' => 'required',
            'anh_dai_dien' => 'mimes:jpeg,jpg,png,gif|max:2048',
            'so_dien_thoai' => 'required|max:10|unique:nhanviens,so_dien_thoai,' . $id,
            // 'quyen' => 'required'
        ], [
            'ma_nhan_vien.required' => 'Tr?????ng d??? li???u kh??ng ???????c ????? tr???ng',
            'ma_nhan_vien.min' => 'D??? li???u nh???p v??o c?? t???i thi???u 3 k?? t???',
            'ma_nhan_vien.max' => 'D??? li???u nh???p v??o c?? t???i ??a 15 k?? t???',
            'ma_nhan_vien.unique' => 'D??? li???u nh???p v??o kh??ng ???????c tr??ng l???p',
            'ho_ten.required' => 'Tr?????ng d??? li???u kh??ng ???????c ????? tr???ng',
            'ho_ten.min' => 'D??? li???u nh???p v??o c?? t???i thi???u 3 k?? t???',
            'ho_ten.max' => 'D??? li???u nh???p v??o c?? t???i ??a 30 k?? t???',
            'phong_ban_id.required' => 'Tr?????ng d??? li???u kh??ng ???????c ????? tr???ng',
            'phong_ban_id.numeric' => 'D??? li???u nh???p v??o ph???i l?? ki???u s???',
            'email.required' => 'Tr?????ng d??? li???u kh??ng ???????c ????? tr???ng',
            'email.max' => 'D??? li???u nh???p v??o c?? t???i ??a 60 k?? t???',
            'email.email' => 'D??? li???u nh???p v??o ph???i l?? d???ng email',
            'email.unique' => 'D??? li???u nh???p v??o kh??ng ???????c tr??ng l???p',
            'ngay_sinh.required' => 'Tr?????ng d??? li???u kh??ng ???????c ????? tr???ng',
            'ngay_sinh.date' => 'D??? li???u nh???p v??o ph???i l?? ki???u ng??y th??ng',
            'ngay_dau_tien.required' => 'Tr?????ng d??? li???u kh??ng ???????c ????? tr???ng',
            'ngay_dau_tien.date' => 'D??? li???u nh???p v??o ph???i l?? ki???u ng??y th??ng',
            'trang_thai.required' => 'Tr?????ng d??? li???u kh??ng ???????c ????? tr???ng',
            'anh_dai_dien.required' => 'Tr?????ng d??? li???u kh??ng ???????c ????? tr???ng',
            'anh_dai_dien.mimes' => 'H??nh ???nh ph???i c?? ?????nh ?????ng jpeg, jpg, png, gif',
            'anh_dai_dien.max' => 'D??? li???u nh???p v??o c?? t???i ??a 10000 kb',
            'so_dien_thoai.required' => 'Tr?????ng d??? li???u kh??ng ???????c ????? tr???ng',
            'so_dien_thoai.max' => 'D??? li???u nh???p v??o c?? t???i ??a 10 k?? t???',
            'so_dien_thoai.unique' => 'D??? li???u nh???p v??o kh??ng ???????c tr??ng l???p',
            // 'quyen.required' => 'Tr?????ng d??? li???u kh??ng ???????c ????? tr???ng'
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
                return redirect()->back()->with('error', 'C???p nh???t th???t b???i');
            }
        }

        if ($nhanvien->save()) {
            if ($request->has('anh_dai_dien')) {
                $hinhanh_resize->save(public_path('uploads/' . $tenanh));
            }
            return redirect()->back()->with('success', 'C???p nh???t th??nh c??ng');
        } else {
            return redirect()->back()->with('error', 'C???p nh???t th???t b???i');
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
            return redirect()->back()->with('success', 'X??a th??nh c??ng');
        } else {
            return redirect()->back()->with('success', 'X??a th??nh c??ng');
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
            'file.required' => 'Tr?????ng d??? li???u kh??ng ???????c ????? tr???ng',
            'file.max' => 'D??? li???u nh???p v??o c?? t???i ??a 10kb',
            'file.mimes' => 'D??? li???u nh???p v??o ph???i l?? file xlsx, xls',
        ]);
        Excel::import(new NhanVienImport, $request->file);
        return back()->with('success', 'Nh???p d??? li???u th??nh c??ng');
    }

    public function resetPassword($id)
    {
        $password = Str::random(10);
        $nhanvien = NhanVien::findOrFail($id);
        $nhanvien->password = bcrypt($password);
        $nhanvien->lan_dau_tien = 'true';
        if ($nhanvien->save()) {
            SendMailResetPassword::dispatch($nhanvien, $password);
            return redirect()->back()->with('success', '???? g???i mail ?????t l???i m???t kh???u');
        } else {
            return redirect()->back()->with('error', 'G???i mail th???t b???i');
        }
    }

    public function profile($id)
    {
        $nhanvien = NhanVien::findOrFail($id);
        return view('quantrivien.nhanvien.hosocanhan', compact('nhanvien'));
    }
}
