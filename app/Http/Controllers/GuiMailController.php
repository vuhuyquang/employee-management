<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendMailRemindBirthday;
use App\Models\NhanVien;
use DB;

class GuiMailController extends Controller
{
    public function sendMail()
    {
        $ngay = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->day;
        $thang = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->month;
        $nhanviens = NhanVien::whereMonth('ngay_sinh', $thang)->whereDay('ngay_sinh', $ngay)->get()->toArray();
        $quanlys = NhanVien::where('quyen', 'manager')->get()->toArray();

        $arrNhanVien = array();
        foreach ($quanlys as $key2 => $quanly) {
            foreach ($nhanviens as $key => $nhanvien) {
                if ($quanly['phong_ban_id'] == $nhanvien['phong_ban_id']) {
                    $arrNhanVien[] = $nhanvien;
                }
            }        
        }

        $emailJob = new SendMailRemindBirthday($nhanvien->ho_ten);
        dispatch($emailJob);
        return redirect()->back();
    }
}
