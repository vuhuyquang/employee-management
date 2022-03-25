<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PhongBanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phongbans')->insert([
            'id' => '1',
            'ma_phong_ban' => 'DEPOFF',
            'ten' => 'Hành chính',
            'mo_ta' => null,
            'truong_phong_id' => '1',
            'created_at' => \Carbon\Carbon::now('Asia/Ho_Chi_Minh'),
            'updated_at' => \Carbon\Carbon::now('Asia/Ho_Chi_Minh')
        ]);
    }
}
