<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $tabel = 'services';
    protected $fillable = [
        'unit_type',
        'price',
        'status',
        'user',
        'customer',
        'vehicle_number',
        'promo',
        'transaction_code',
    ];
    protected $hidden = [];
}
