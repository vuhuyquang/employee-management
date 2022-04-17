<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SMRemindBirthday;
use App\Models\NhanVien;
use DB;

class GuiMailController extends Controller
{
    public function sendMail()
    {
        $ngay = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->day;
        $thang = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->month;
        $nhanviens = NhanVien::whereMonth('ngay_sinh', $thang)->whereDay('ngay_sinh', $ngay)->get()->toArray();
        $quanlys = NhanVien::where('quyen', 'manager')->orWhere('quyen', 'admin')->get()->toArray();

        $arrNhanVien = array();
        foreach ($quanlys as $key2 => $quanly) {
            foreach ($nhanviens as $key => $nhanvien) {
                if ($nhanvien['phong_ban_id'] == $quanly['phong_ban_id']) {
                    $arrNhanVien[] = $nhanvien;
                    $email = $quanly['email'];
                }
            }
            if ($arrNhanVien != null) {
                $data = ['arrNhanVien' => $arrNhanVien, 'email' => $email];
                // RemindBirthday::dispatch($data);
                if (dispatch(new SMRemindBirthday($data))) {
                    $arrNhanVien = (array) null;
                }
            }
        }
        return redirect()->back();
    }
}
