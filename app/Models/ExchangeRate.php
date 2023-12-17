<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangeRate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'provider_name',
        'code',
        'description',
        'rate_buy',
        'rate_sell'
    ];

    protected $hidden = [
        'id',
        'provider_name',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
