@extends('layouts.admin')
@section('main')
    <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Mã nhân viên</label>
            <input type="text" class="form-control" name="ma_nhan_vien" placeholder="Nhập mã nhân viên" autocomplete="off"
                required>
            @error('ma_nhan_vien')
                <small class="help-block">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Họ tên</label>
            <input type="text" class="form-control" name="ho_ten" placeholder="Nhập họ tên" autocomplete="off" required>
            @error('ho_ten')
                <small class="help-block">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Phòng ban</label>
            <select class="form-control" name="phong_ban_id">
                <option value="" selected disabled>--- Chọn phòng ban ---</option>
                @foreach ($phongbans as $phongban)
                    <option value="{{ $phongban->id }}">{{ $phongban->ten }}</option>
                @endforeach
            </select>
            @error('phong_ban_id')
                <small class="help-block">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" name="email" placeholder="Nhập email" autocomplete="off" required>
            @error('email')
                <small class="help-block">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" autocomplete="off" required>
            @error('password')
                <small class="help-block">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Ngày sinh</label>
            <input type="date" class="form-control" name="ngay_sinh" placeholder="Nhập ngày sinh" autocomplete="off">
            @error('ngay_sinh')
                <small class="help-block">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Ngày đầu đi làm</label>
            <input type="date" class="form-control" name="ngay_dau_tien" placeholder="Nhập ngày đầu tiên" autocomplete="off">
            @error('ngay_dau_tien')
                <small class="help-block">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Trạng thái</label>
            <div class="radio">
                <p>
                    <input type="radio" name="trang_thai" value="1">
                    Đang làm việc
                </p>
                <p>
                    <input type="radio" name="trang_thai" value="0">
                    Đã nghỉ việc
                </p>
            </div>
        </div>
        <div class="form-group">
            <label>Ảnh đại diện</label>
            <input type="file" class="form-control" name="anh_dai_dien" autocomplete="off">
            @error('anh_dai_dien')
                <small class="help-block">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" class="form-control" name="so_dien_thoai" placeholder="Nhập số điện thoại" autocomplete="off">
            @error('so_dien_thoai')
                <small class="help-block">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
@stop()
