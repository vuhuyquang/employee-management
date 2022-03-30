@extends('layouts.admin')

@section('main')

    <div class="row">
        <div class="col">
            <form action="" class="form-inline">
                <div class="form-group">
                    <input class="form-control" name="key" placeholder="Nhập tên phòng ban" autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="col">
            <div class="row form-group float-right">
                <form action="{{ route('department.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col">
                        <a href="{{ route('department.export') }}" class="nutxuat">Xuất file</a>
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
                <th>Mã phòng ban</th>
                <th>Tên</th>
                <th>Mô tả</th>
                <th>Trưởng phòng</th>
                <th>Số nhân viên</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($phongbans as $key => $phongban)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $phongban->ma_phong_ban }}</td>
                    <td>{{ $phongban->ten }}</td>
                    <td>
                        @if ($phongban->mo_ta === null)
                            <i>Chưa có thông tin</i>
                        @else
                            {{ $phongban->mo_ta }}
                        @endif
                    </td>
                    <td>
                        @if ($phongban->truong_phong_id === null)
                            <i>Chưa có thông tin</i>
                        @else
                            @if (isset($phongban->nhanvien->ho_ten))
                                {{ $phongban->nhanvien->ho_ten }}
                            @else
                                <i>Chưa có thông tin</i>
                            @endif
                        @endif
                    </td>
                    <td>{{ $phongban->nhanviens->count() }}</td>
                    <td>{{ date('d/m/Y H:i:s', strtotime($phongban->created_at)) }}</td>
                    <td>
                        <a href="{{ route('department.edit', $phongban->id) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('department.destroy', $phongban->id) }}"
                            class="btn btn-sm btn-danger btndelete" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    {{ $phongbans->links() }}
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
