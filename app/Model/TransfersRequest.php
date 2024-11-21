<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TransfersRequest extends Model
{
    protected $guarded = ['id'];


    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }
}
