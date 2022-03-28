<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class NhanVien extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'nhanviens';
    // protected $guarded = 'admin';
    protected $fillable = [
        'ma_nhan_vien',
        'ho_ten',
        'phong_ban_id',
        'email',
        'password',
        'ngay_sinh',
        'ngay_dau_tien',
        'trang_thai',
        'anh_dai_dien',
        'so_dien_thoai',
        'quyen'
    ];
    protected $hidden = [
        'password', 'remember_token',
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
    		return $query->where('ma_nhan_vien', 'like', '%'.$key.'%')->orWhere('ho_ten', 'like', '%'.$key.'%');
    	} elseif ($id = request()->id) {
            return $query->where('phong_ban_id', $id);
        } elseif ($status = request()->status) {
            return $query->where('trang_thai', $status);
        } 
    }
}
