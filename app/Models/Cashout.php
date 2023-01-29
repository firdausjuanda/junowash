<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cashout extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected  $table = 'cashout';
    
    protected $fillable = [
        'material',
        'active',
        'amount',
        'type',
        'status',
        'user',
        'currency',
        'qty',
    ];
}
