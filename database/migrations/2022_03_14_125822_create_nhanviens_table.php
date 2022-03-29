<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhanviensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhanviens', function (Blueprint $table) {
            $table->id();
            $table->string('ma_nhan_vien', 15)->unique();
            $table->string('ho_ten', 30);
            $table->integer('phong_ban_id');
            $table->string('email', 50);
            $table->string('password', 255);
            $table->date('ngay_sinh');
            $table->date('ngay_dau_tien');
            $table->integer('trang_thai')->default(1)->comment('1: Đang làm việc, 0: Đã nghỉ việc');
            $table->text('anh_dai_dien');
            $table->string('so_dien_thoai', 10)->nullable()->unique();
            $table->string('lan_dau_tien', 10)->default('false');
            $table->string('quyen')->default('employee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nhanviens');
    }
}
