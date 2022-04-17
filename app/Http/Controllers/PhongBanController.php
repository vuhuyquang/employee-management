<?php

namespace App\Http\Controllers;

use App\Models\PhongBan;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use App\Exports\PhongBanExport;
use App\Imports\PhongBanImport;
use Excel;
use App\Http\Requests\PhongBanRequest;

class PhongBanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phongbans = PhongBan::orderBy('id', 'DESC')->search()->paginate(15);
        return view('quantrivien.phongban.danhsach', compact('phongbans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nhanviens = NhanVien::where('quyen', 'employee');
        return view('quantrivien.phongban.them', compact('nhanviens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhongBanRequest $request)
    {
        $phongban = new PhongBan;
        $phongban->ma_phong_ban = $request->ma_phong_ban;
        $phongban->ten = $request->ten;
        $phongban->mo_ta = $request->mo_ta;
        $phongban->truong_phong_id = $request->truong_phong_id;
        if ($phongban->save()) {
            if ($request->truong_phong_id !== null) {
                $this->setleader($request->truong_phong_id);
            }
            return redirect()->back()->with('success', 'Thêm mới thành công');
        } else {
            return redirect()->back()->with('error', 'Thêm mới thất bại');
        }
    }

    public function setleader($id)
    {
        $nhanvien = NhanVien::findOrFail($id);
        if ($nhanvien->quyen != 'admin') {
            $nhanvien->quyen = 'manager';
            $nhanvien->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PhongBan  $phongBan
     * @return \Illuminate\Http\Response
     */
    public function show(PhongBan $phongBan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhongBan  $phongBan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nhanviens = NhanVien::where('phong_ban_id', $id)->orWhere('quyen', '=', 'admin')->get();
        $phongban = PhongBan::findOrFail($id);
        return view('quantrivien.phongban.sua', compact('phongban', 'nhanviens'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PhongBan  $phongBan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ma_phong_ban' => 'required|min:3|max:15|unique:phongbans,ma_phong_ban,' . $id,
            'ten' => 'required|min:3|max:50|unique:phongbans,ten,' . $id,
            'mo_ta' => 'max:254',
            'truong_phong_id' => 'unique:phongbans,truong_phong_id,' . $id
        ], [
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
        ]);

        $phongban = PhongBan::findOrFail($id);
        $oldManagerId = $phongban->truong_phong_id;
        $nhanvien = NhanVien::find($oldManagerId);
        if ($nhanvien) {
            $nhanvien->quyen = 'employee';
            $nhanvien->save();
        }
        $phongban->ma_phong_ban = $request->ma_phong_ban;
        $phongban->ten = $request->ten;
        $phongban->mo_ta = $request->mo_ta;
        $phongban->truong_phong_id = $request->truong_phong_id;
        if ($phongban->save()) {
            if ($request->truong_phong_id !== null) {
                $this->setleader($request->truong_phong_id);
            }
            return redirect()->back()->with('success', 'Cập nhật thành công');
        } else {
            return redirect()->back()->with('error', 'Cập nhật thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhongBan  $phongBan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phongban = PhongBan::findOrFail($id);
        if ($phongban->nhanviens->count() === 0) {
            $phongban->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } else {
            return redirect()->back()->with('error', 'Xóa thất bại');
        }
    }

    public function export()
    {
        return Excel::download(new PhongBanExport, 'DepartmentList.xlsx');
    }
}
