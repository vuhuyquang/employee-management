<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhongBanController;
use App\Http\Controllers\QuanTriVienController;
use App\Http\Controllers\QuanLyController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\GuiMailController;
use App\Models\NhanVien;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('dang-nhap', [AuthController::class, 'getLogin'])->name('getLogin');
Route::post('dang-nhap', [AuthController::class, 'postLogin'])->name('postLogin');
Route::get('chuyen-huong', [AuthController::class, 'redirect'])->name('redirect');
Route::get('dang-xuat', [AuthController::class, 'getLogout'])->name('getLogout');
Route::get('doi-mat-khau', [AuthController::class, 'getChangePassword'])->name('getChangePassword');
Route::post('doi-mat-khau', [AuthController::class, 'postChangePassword'])->name('postChangePassword');
Route::get('ho-so-ca-nhan', [AuthController::class, 'getProfile'])->name('getProfile');
Route::post('ho-so-ca-nhan', [AuthController::class, 'postProfile'])->name('postProfile');
Route::get('trang-chu', [AuthController::class, 'home'])->name('home');

Route::prefix('quan-tri-vien')->middleware('checkAdmin')->group(function () {
    Route::prefix('phong-ban')->group(function () {
        Route::get('', [PhongBanController::class, 'index'])->name('department.index');
        Route::get('them', [PhongBanController::class, 'create'])->name('department.create');
        Route::post('them', [PhongBanController::class, 'store'])->name('department.store');
        Route::get('sua/{id}', [PhongBanController::class, 'edit'])->name('department.edit')->where('id', '[0-9]+');
        Route::post('sua/{id}', [PhongBanController::class, 'update'])->name('department.update')->where('id', '[0-9]+');
        Route::get('xoa/{id}', [PhongBanController::class, 'destroy'])->name('department.destroy')->where('id', '[0-9]+');
        Route::get('xuat-file-excel', [PhongBanController::class, 'export'])->name('department.export');
        Route::post('nhap-file-excel', [PhongBanController::class, 'import'])->name('department.import');
    });

    Route::prefix('nhan-vien')->group(function () {
        Route::get('', [NhanVienController::class, 'index'])->name('employee.index');
        Route::get('them', [NhanVienController::class, 'create'])->name('employee.create');
        Route::post('them', [NhanVienController::class, 'store'])->name('employee.store');
        Route::get('sua/{id}', [NhanVienController::class, 'edit'])->name('employee.edit')->where('id', '[0-9]+');
        Route::post('sua/{id}', [NhanVienController::class, 'update'])->name('employee.update')->where('id', '[0-9]+');
        Route::get('xoa/{id}', [NhanVienController::class, 'destroy'])->name('employee.destroy')->where('id', '[0-9]+');
        Route::get('xuat-file-excel', [NhanVienController::class, 'export'])->name('employee.export');
        Route::post('nhap-file-excel', [NhanVienController::class, 'import'])->name('employee.import');
        Route::get('dat-lai-mat-khau/{id}', [NhanVienController::class, 'resetPassword'])->name('resetPassword');
    });
});

Route::prefix('quan-ly')->middleware('checkManager')->group(function () {
    Route::get('', [NhanVienController::class, 'listEmployee'])->name('list.employee');
    Route::get('xuat-file-excel', [NhanVienController::class, 'managerExport'])->name('manager.employee.export');
    Route::get('gui-mail', [GuiMailController::class, 'sendMail'])->name('sendMail');
});

Route::prefix('nhan-vien')->middleware('checkEmployee')->group(function () {
});
