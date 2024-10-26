<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongSoTrong extends Model
{
    use HasFactory;

    protected $table = "thongsotrong";

    protected $fillable = [
        'MaCLT',
        'TenCLT',
        'MauTrong',
        'DoRongTrong',
        'DoCaoTrong'
    ];
}
