<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "sanpham";

    protected $fillable = [
        'MaSP',
        'TenSP',
        'GioiTinh',
        'Do',
        'ThuongHieu',
        'LoaiMatKinh',
        'MaCLG',
        'MaCLT',
        'GiaBan',
        'SoLuongTonKho',
        'MoTaChiTiet',
        'AnhSP',
        'TrangThaiSP',
        'DanhGiaTB',
        'SoLuongDanhGia',
        'MaKM',
        'NgayTaoSP',
        'NgaySuaSP',
        'NgayXoaSP',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'MaLoai', 'LoaiMatKinh'); // giả sử bạn có thuộc tính category_id trong bảng products
    }

}
