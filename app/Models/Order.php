<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'nama_pelanggan',
        'nama_laundry',
        'jenis_laundry',
        'berat',
        'total_harga',
        'status',
    ];
}