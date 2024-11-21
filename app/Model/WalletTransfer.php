<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WalletTransfer extends Model
{
    protected $guarded = ['id'];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
