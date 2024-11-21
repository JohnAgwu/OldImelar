<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'data'  => 'array'
    ];
}
