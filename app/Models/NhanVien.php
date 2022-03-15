<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    use HasFactory;
    protected $table = 'nhanviens';
    protected $fillable = [
        'ma_nhan_vien',
        'ho_ten',
        'phong_ban_id',
        'ngay_sinh',
        'ngay_dau_tien',
        'trang_thai',
        'anh_dai_dien',
        'so_dien_thoai',
        'quyen'
    ];

    public function phongbans()
    {
        return $this->hasOne(PhongBan::class, 'id', 'phong_ban_id');
    }

    public function phongban()
    {
        return $this->hasOne(PhongBan::class, 'truong_phong_id', 'id');
    }

    public function scopeSearch($query)
    {
        if ($key = request()->key) {
    		return $query->where('ho_ten', $key);
    	}
    }
}
