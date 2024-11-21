<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PromoPage extends Model
{
    protected $guarded = ['id'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
