<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $tabel = 'services';
    protected $fillable = [
        'unitType',
        'price',
        'status',
        'user',
    ];
    protected $hidden = [];
}
