@extends('layouts.admin')
@section('main')
    <div class="form-group">
        <label for="">Thêm mới bằng cách nhập dữ liệu (hoặc nhập file excel)</label>
    </div>
    <form action="{{ route('department.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-4">
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file" accept=".xlsx" id="validatedCustomFile"
                            required>
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        @error('file')
                            <small class="help-block">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-outline-secondary" type="button" id="button-addon2">Nhập
                        file</button>
                </div>
            </div>
        </div>
    </form>
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
