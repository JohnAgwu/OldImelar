<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItemsReturnedByCustomer extends Model
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
