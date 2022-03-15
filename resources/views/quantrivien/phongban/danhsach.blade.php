@extends('layouts.admin')

@section('main')
<form action="" class="form-inline">
	<div class="form-group">
		<input class="form-control" name="key" placeholder="Nhập tên phòng ban" autocomplete="off">
	</div>
	<button type="submit" class="btn btn-primary">
		<i class="fas fa-search"></i>
	</button>
</form>
<hr>

<table style="text-align: center" class="table table-hover">
	<thead>
		<tr>
			<th>STT</th>
			<th>Mã phòng ban</th>
			<th>Tên</th>
			<th>Mô tả</th>
			<th>Trưởng phòng</th>
			<th>Ngày tạo</th>
			<th>Hành động</th>
		</tr>
	</thead>
	<tbody>
	@foreach($phongbans as $key => $phongban)
		<tr>
			<td>{{$key+1}}</td>
			<td>{{$phongban->ma_phong_ban}}</td>
			<td>{{$phongban->ten}}</td>
			<td>
				@if ($phongban->mo_ta === null)
					<i>Chưa có thông tin</i>
				@else
					{{$phongban->mo_ta}}
				@endif
			</td>
			<td>
				@if ($phongban->truong_phong_id === null)
					<i>Chưa có thông tin</i>
				@else
					{{$phongban->nhanvien->ho_ten}}
				@endif
			</td>
			<td>{{ date('d/m/Y H:i:s', strtotime($phongban->created_at))}}</td>
			<td>
				<a href="{{ route('department.edit', $phongban->id) }}" class="btn btn-sm btn-success">
					<i class="fas fa-edit"></i>
				</a>
				<a href="{{ route('department.destroy', $phongban->id) }}" class="btn btn-sm btn-danger btndelete" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
					<i class="fas fa-trash"></i>
				</a>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
@stop()