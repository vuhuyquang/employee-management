<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendMailRemindBirthday;
use App\Models\NhanVien;

class GuiMailController extends Controller
{
    public function sendMail()
    {
        $nhanvien = NhanVien::where('ngay_sinh',  \Carbon\Carbon::now('Asia/Ho_Chi_Minh'))->get();
        $emailJob = new SendMailRemindBirthday($nhanvien);
        dispatch($emailJob);
        return redirect()->back();
    }
}
