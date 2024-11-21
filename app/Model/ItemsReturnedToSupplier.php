<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItemsReturnedToSupplier extends Model
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
