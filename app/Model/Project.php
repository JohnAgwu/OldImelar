<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'expenses'      => 'array'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function payable()
    {
        return $this->hasOne(Payable::class);
    }
}
