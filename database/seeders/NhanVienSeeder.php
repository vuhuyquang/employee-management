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

        DB::table('nhanviens')->insert([
            'id' => '2',
            'ma_nhan_vien' => 'EMPIT0001',
            'ho_ten' => 'Cao Việt Hoàng',
            'phong_ban_id' => '2',
            'email' => 'caohoang@gmail.com',
            'password' => bcrypt('123456'),
            'ngay_sinh' => '2000/04/14',
            'ngay_dau_tien' => \Carbon\Carbon::now('Asia/Ho_Chi_Minh'),
            'trang_thai' => 1,
            'anh_dai_dien' => 'avatar_default.png',
            'so_dien_thoai' => null,
            'quyen' => 'employee',
        ]);

        DB::table('nhanviens')->insert([
            'id' => '3',
            'ma_nhan_vien' => 'EMPIT0002',
            'ho_ten' => 'Đinh Hữu Thành',
            'phong_ban_id' => '2',
            'email' => 'onechampalistarandannie@gmail.com',
            'password' => bcrypt('123456'),
            'ngay_sinh' => '2000/04/14',
            'ngay_dau_tien' => \Carbon\Carbon::now('Asia/Ho_Chi_Minh'),
            'trang_thai' => 1,
            'anh_dai_dien' => 'avatar_default.png',
            'so_dien_thoai' => null,
            'quyen' => 'manager',
        ]);

        DB::table('nhanviens')->insert([
            'id' => '4',
            'ma_nhan_vien' => 'EMPOFF0002',
            'ho_ten' => 'Trần Văn Khương',
            'phong_ban_id' => '1',
            'email' => 'khuongchuc2k1@gmail.com',
            'password' => bcrypt('123456'),
            'ngay_sinh' => '2001/04/14',
            'ngay_dau_tien' => \Carbon\Carbon::now('Asia/Ho_Chi_Minh'),
            'trang_thai' => 1,
            'anh_dai_dien' => 'avatar_default.png',
            'so_dien_thoai' => null,
            'quyen' => 'employee',
        ]);

        $model->fill($data);
        $model->save();
    }
}
