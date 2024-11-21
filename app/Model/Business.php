<?php

namespace App\Model;

use App\Model\Customer;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $appends = ['total_income'];

    protected $casts = [
        'social'    => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function receivables()
    {
        return $this->hasMany(Receivable::class);
    }

    public function payables()
    {
        return $this->hasMany(Payable::class);
    }

    public function itemsReturnedToSupplier()
    {
        return $this->hasMany(ItemsReturnedToSupplier::class);
    }

    public function itemsReturnedByCustomer()
    {
        return $this->hasMany(ItemsReturnedByCustomer::class);
    }

    public function getTotalIncomeAttribute()
    {
        $totalIncome = 0;
        $invoices = $this->invoices()->where('payment_status', 'FULLY PAID')->get();

        $invoices->each(function ($invoice) use (&$totalIncome) {
            if ($invoice->business->isFreelance() ) {
                $totalIncome += $invoice->projects()->sum('price');
            }
            else {
                $totalIncome += $invoice->products()->sum('amount');
            }
        });

        $totalIncome += $this->invoices()->where('payment_status', 'PART PAYMENT')->sum('amount_paid');

        return $totalIncome;
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function promoPages()
    {
        return $this->hasMany(PromoPage::class);
    }

    public function isFreelance() : bool
    {
        return $this->mode == 'FREELANCE';
    }
}
