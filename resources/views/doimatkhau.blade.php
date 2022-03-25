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
                        <div class="card-header">Đổi mật khẩu</div>
                        <div class="card-body">
                            <form action="{{ route('postChangePassword') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="oldPassword" class="col-md-4 col-form-label text-md-right">Mật khẩu
                                        hiện tại</label>
                                    <div class="col-md-6">
                                        <input type="password" id="oldPassword" class="form-control" name="oldPassword"
                                            required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="newPassword" class="col-md-4 col-form-label text-md-right">Mật khẩu
                                        mới</label>
                                    <div class="col-md-6">
                                        <input type="password" id="newPassword" class="form-control" name="newPassword"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="reNewPassword" class="col-md-4 col-form-label text-md-right">Xác nhận mật
                                        khẩu mới</label>
                                    <div class="col-md-6">
                                        <input type="password" id="reNewPassword" class="form-control"
                                            name="reNewPassword" required>
                                    </div>
                                </div>

                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Lưu
                                    </button>
                                    <a href="#" class="btn btn-link">
                                        Quên mật khẩu?
                                    </a>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @stop
