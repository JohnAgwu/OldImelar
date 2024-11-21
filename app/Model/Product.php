<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
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

    public function image()
    {
        return $this->hasOne(ProductImage::class);
    }

    public function payable()
    {
        return $this->hasOne(Payable::class);
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }
}
