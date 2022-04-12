@extends('layouts.admin')
@section('main')
    <form action="{{ route('department.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Mã phòng ban <label for="" style="color: red;">*</label></label>
            <input type="text" class="form-control" name="ma_phong_ban" placeholder="Nhập mã phòng ban" autocomplete="off"
                required>
            @error('ma_phong_ban')
                <small class="help-block">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Phòng ban <label for="" style="color: red;">*</label></label>
            <input type="text" class="form-control" name="ten" placeholder="Nhập phòng ban" autocomplete="off" required>
            @error('ten')
                <small class="help-block">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Mô tả</label>
            <input type="text" class="form-control" name="mo_ta" placeholder="Nhập mô tả" autocomplete="off">
            @error('mo_ta')
                <small class="help-block">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
@stop()
