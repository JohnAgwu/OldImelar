<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    public $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function transfers()
    {
        return $this->hasMany(WalletTransfer::class);
    }

    public function requests()
    {
        return $this->hasMany(TransfersRequest::class);
    }
}
