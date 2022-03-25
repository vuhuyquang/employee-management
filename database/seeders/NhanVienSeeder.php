<?php

namespace Database\Seeders;

use App\Models\NhanVien;
use Illuminate\Database\Seeder;
use DB;

class NhanVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new NhanVien();
        $data = [
            'id' => '1',
            'ma_nhan_vien' => 'EMPOFF0001',
            'ho_ten' => 'Vũ Huy Quang',
            'phong_ban_id' => '1',
            'email' => 'vuhuyquang2k@gmail.com',
            'password' => bcrypt('123456'),
            'ngay_sinh' => \Carbon\Carbon::now('Asia/Ho_Chi_Minh'),
            'ngay_dau_tien' => \Carbon\Carbon::now('Asia/Ho_Chi_Minh'),
            'trang_thai' => 1,
            'anh_dai_dien' => 'avatar_default.png',
            'so_dien_thoai' => null,
            'quyen' => 'admin',

        ];
        $model->fill($data);
        $model->save();
    }
}
