<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhongbansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phongbans', function (Blueprint $table) {
            $table->id();
            $table->string('ma_phong_ban', 15)->unique();
            $table->string('ten', 50)->unique();
            $table->string('mo_ta', 255)->nullable();
            $table->integer('truong_phong_id')->unique()->nullable();
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
        Schema::dropIfExists('phongbans');
    }
}
