<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemindBirthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:mail_remind_birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ngay = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->day;
        $thang = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->month;
        $nhanviens = NhanVien::whereMonth('ngay_sinh', $thang)->whereDay('ngay_sinh', $ngay)->get()->toArray();
        $quanlys = NhanVien::where('quyen', 'manager')->where('quyen', 'admin')->get()->toArray();

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
                RemindBirthday::dispatch($data);
            }
        }
    }
}
