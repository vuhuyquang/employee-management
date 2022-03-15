<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhongBanController;
use App\Http\Controllers\QuanTriVienController;
use App\Http\Controllers\QuanLyController;
use App\Http\Controllers\NhanVienController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('quan-tri-vien')->group(function () {
    Route::get('', [AuthController::class, 'home'])->name('home');

    Route::prefix('phong-ban')->group(function () {
        Route::get('', [PhongBanController::class, 'index'])->name('department.index');
        Route::get('them', [PhongBanController::class, 'create'])->name('department.create');
        Route::post('them', [PhongBanController::class, 'store'])->name('department.store');
        Route::get('sua/{id}', [PhongBanController::class, 'edit'])->name('department.edit')->where('id', '[0-9]+');
        Route::post('sua/{id}', [PhongBanController::class, 'update'])->name('department.update')->where('id', '[0-9]+');
        Route::get('xoa/{id}', [PhongBanController::class, 'destroy'])->name('department.destroy')->where('id', '[0-9]+');
    });

    Route::prefix('nhan-vien')->group(function () {
        Route::get('', [NhanVienController::class, 'index'])->name('employee.index');
        Route::get('them', [NhanVienController::class, 'create'])->name('employee.create');
        Route::post('them', [NhanVienController::class, 'store'])->name('employee.store');
        Route::get('sua/{id}', [NhanVienController::class, 'edit'])->name('employee.edit')->where('id', '[0-9]+');
        Route::post('sua/{id}', [NhanVienController::class, 'update'])->name('employee.update')->where('id', '[0-9]+');
        Route::get('xoa/{id}', [NhanVienController::class, 'destroy'])->name('employee.destroy')->where('id', '[0-9]+');
    });
});

Route::prefix('quan-ly')->group(function () {
    Route::get('', );
});

Route::prefix('nhan-vien')->group(function () {
    Route::get('', );
});
