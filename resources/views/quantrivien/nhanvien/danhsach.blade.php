@extends('layouts.admin')

@section('main')
    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('filter') }}" class="form-inline" method="GET">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="htmnv">Họ tên/Mã nhân viên</label>
                                </div>
                                <div class="form-group">
                                    <input id="htmnv" class="form-control" name="key" placeholder="Nhập họ tên/mã nhân viên"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="id">Phòng ban</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="id" id="id">
                                        <option value="" selected disabled>--- Chọn phòng ban ---</option>
                                        @foreach ($phongbans as $phongban)
                                            <option value="{{ $phongban->id }}">{{ $phongban->ten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="id">Phòng ban</label>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="status" id="status">
                                        <option value="" selected disabled>--- Chọn trạng thái ---</option>
                                        <option value="1">Đang làm việc</option>
                                        <option value="2">Đã nghỉ việc</option>
                                    </select>
                                </div>
                            </div>
                            <div style="" class="col mt-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <form action="{{ route('date') }}" method="GET" class="form-inline">
                    <div class="col">
                        <div class="form-group">
                            <select class="form-control" name="day" id="status">
                                <option value="" selected disabled>--- Sắp xếp ---</option>
                                <option value="1">Ngày sinh ASC</option>
                                <option value="2">Ngày sinh DESC</option>
                                <option value="3">Ngày đầu tiên ASC</option>
                                <option value="4">Ngày đầu tiên DESC</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row form-group float-right">
                <form action="{{ route('employee.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col">
                        <a href="{{ route('employee.export') }}" class="nutxuat">Xuất file</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <hr>
    <table style="text-align: center" class="table table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã nhân viên</th>
                <th>Họ tên</th>
                <th>Phòng ban</th>
                <th>Email</th>
                {{-- <th>Ngày sinh</th> --}}
                <th>Trạng thái</th>
                {{-- <th>SĐT</th> --}}
                <th>Quyền</th>
                {{-- <th>Ngày tạo</th> --}}
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nhanviens as $key => $nhanvien)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $nhanvien->ma_nhan_vien }}</td>
                    <td>{{ $nhanvien->ho_ten }}</td>
                    <td>{{ $nhanvien->phongbans->ten }}</td>
                    <td>{{ $nhanvien->email }}</td>
                    {{-- <td>{{ date('d/m/Y', strtotime($nhanvien->ngay_sinh)) }}</td> --}}
                    <td>
                        @if ($nhanvien->trang_thai == 1)
                            <span class="badge badge-success">Đang làm việc</span>
                        @else
                            <span class="badge badge-danger">Đã nghỉ việc</span>
                        @endif
                    </td>
                    {{-- <td>{{ $nhanvien->so_dien_thoai }}</td> --}}
                    <td>
                        @switch($nhanvien->quyen)
                            @case('admin')
                                Quản trị viên
                            @break

                            @case('manager')
                                Trưởng phòng
                            @break

                            @case('employee')
                                Nhân viên
                            @break

                            @default
                                <i>Chưa có thông tin</i>
                        @endswitch
                    </td>
                    {{-- <td><img style="height: 30px; width: 30px;" src="{{asset('uploads')}}/{{$nhanvien->anh_dai_dien}}" alt="Ảnh đại diện của {{$nhanvien->ho_ten}}"></td> --}}
                    {{-- <td>{{ date('d/m/Y H:i:s', strtotime($nhanvien->created_at)) }}</td> --}}
                    <td>
                        <a href="{{ route('resetPassword', $nhanvien->id) }}" class="btn btn-sm btn-warning">
                            <i style="color: white;" class="fas fa-key"></i>
                        </a>
                        <a href="{{ route('profile', $nhanvien->id) }}" class="btn btn-sm btn-info">
                            <i style="color: white;" class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('employee.edit', $nhanvien->id) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('employee.destroy', $nhanvien->id) }}" class="btn btn-sm btn-danger btndelete"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    {{ $nhanviens->links() }}
@stop()

@section('css')
    <style>
        .nutxuat {
            float: right;
            border-radius: 2px;
            cursor: pointer;
            font-size: .88em;
            line-height: 1.6em;
            color: white;
            white-space: nowrap;
            padding: 6px;
            border-radius: 5px;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .nutxuat:hover {
            color: white;
            border-color: #949da5;
        }

    </style>
@endsection
