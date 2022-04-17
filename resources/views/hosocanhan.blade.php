@extends('layouts.admin')
@section('main')

    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-footer-->
                        </div>
                        <div class="card-header">Hồ sơ cá nhân</div>
                        <div class="card-body">
                            <form action="{{ route('postProfile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="ma_nhan_vien" class="col-md-4 col-form-label text-md-right">Mã nhân
                                        viên</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{{ $nhanvien->ma_nhan_vien }}" id="ma_nhan_vien"
                                            class="form-control" name="ma_nhan_vien" required autofocus readonly class="form-control-plaintext">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ho_ten" class="col-md-4 col-form-label text-md-right">Họ tên</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{{ $nhanvien->ho_ten }}" id="ho_ten"
                                            class="form-control" name="ho_ten" required autofocus readonly class="form-control-plaintext">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phong_ban_id" class="col-md-4 col-form-label text-md-right">Phòng
                                        ban</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="phong_ban_id">
                                            @foreach ($phongbans as $phongban)
                                                @if ($nhanvien->phong_ban_id == $phongban->id)
                                                    <option {{ $nhanvien->phong_ban_id == $phongban->id ? 'selected' : '' }}
                                                        value="{{ $phongban->id }}">{{ $nhanvien->phongbans->ten }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{{ $nhanvien->email }}" id="email"
                                            class="form-control" name="email" required autofocus readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ngay_sinh" class="col-md-4 col-form-label text-md-right">Ngày
                                        sinh</label>
                                    <div class="col-md-6">
                                        <input type="date" value="{{ $nhanvien->ngay_sinh }}" id="ngay_sinh"
                                            class="form-control" name="ngay_sinh" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ngay_dau_tien" class="col-md-4 col-form-label text-md-right">Ngày đàu đi
                                        làm</label>
                                    <div class="col-md-6">
                                        <input type="date" value="{{ $nhanvien->ngay_dau_tien }}" id="ngay_dau_tien"
                                            class="form-control" name="ngay_dau_tien" required readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="trang_thai" class="col-md-4 col-form-label text-md-right">Trạng thái</label>
                                    <div class="col-md-6">
                                        <div class="radio">
                                            @if ($nhanvien->trang_thai == '1')
                                                <p>
                                                    <input checked type="radio" name="trang_thai" value="1">
                                                    Đang làm việc
                                                </p>
                                            @else
                                                <p>
                                                    <input checked type="radio" name="trang_thai" value="0">
                                                    Đã nghỉ việc
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="anh_dai_dien" class="col-md-4 col-form-label text-md-right">Ảnh đại
                                        diện</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="anh_dai_dien" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="so_dien_thoai"
                                        class="col-md-4 col-form-label text-md-right">Số điện
                                        thoại</label>
                                    <div class="col-md-6">
                                        <input type="text" id="so_dien_thoai" value="{{ $nhanvien->so_dien_thoai }}" class="form-control" name="so_dien_thoai">
                                    </div>
                                </div>

                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Lưu
                                    </button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @stop
