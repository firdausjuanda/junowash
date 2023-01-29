<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForgotPassword extends Model
{
    use HasFactory;

    protected $table = 'forgot_password';
    protected $fillable = [
        'user_id',
        'token',
    ];

    protected $hidden = [];
}
