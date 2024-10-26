<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongSoGong extends Model
{
    use HasFactory;

    protected $table = "thongsogong";

    protected $fillable = [
        'MaCLG',
        'TenCLG',
        'MauGong',
        'ChieuDaiGongKinh',
        'ChieuRongGongKinh'
    ];
}
