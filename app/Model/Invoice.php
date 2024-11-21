<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = ['created_at', 'updated_at', 'dispatched_at', 'payment_date', 'payment_due_date'];

    protected $casts = [
        'expenses'      => 'array'
    ];

    protected $appends = ['products_sum', 'days_overdue'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }

    public function projects()
    {
        return $this->hasMany(InvoiceProject::class);
    }

    public function payable()
    {
        return $this->hasOne(Payable::class);
    }

    public function receivable()
    {
        return $this->hasOne(Receivable::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getProductsSumAttribute()
    {
        if ( $this->business->isFreelance() ) {
            return $this->projects->sum('price');
        }

        return $this->products->sum('amount');
    }

    public function getDaysOverdueAttribute()
    {
        return now()->diffInDays($this->payment_due_date);
    }
}
