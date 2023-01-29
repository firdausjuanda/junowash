<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expenses extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'expenses';

    protected $fillable = [
        'category',
        'status',
        'description',
        'amount',
        'user_id',
        'supplier_id',
    ];

    protected $hidden = [];
}
