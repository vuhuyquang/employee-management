<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongBan extends Model
{
    use HasFactory;
    protected $table = 'phongbans';
    protected $fillable = ['ma_phong_ban', 'ten', 'mo_ta'];

    public function nhanviens()
    {
        return $this->hasMany(NhanVien::class, 'phong_ban_id', 'id');
    }

    public function nhanvien()
    {
        return $this->hasOne(NhanVien::class, 'id', 'truong_phong_id');
    }

    public function scopeSearch($query)
    {
        if ($key = request()->key) {
    		return $query->where('ten', $key);
    	}
    }
}
