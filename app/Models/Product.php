<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'category_id',
        'brand',
        'model',
        'img',
        'price',
        'uom',
    ];

    protected $hidden = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function price()
    {
        return $this->hasOne(Pricelist::class);
    }
}
