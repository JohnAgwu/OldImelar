<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStock extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'expenses'      => 'array'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
