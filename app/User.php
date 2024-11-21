<?php

namespace App;

use App\Model\Bank;
use App\Model\Business;
use App\Model\Customer;
use App\Model\DebitCard;
use App\Model\Invoice;
use App\Model\Wallet;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date',
    ];

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function invoices()
    {
        return $this->hasManyThrough(Invoice::class, Customer::class);
    }

    public function debitCards()
    {
        return $this->hasMany(DebitCard::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function banks()
    {
        return $this->hasManyThrough(Bank::class, Business::class, 'user_id', 'business_id');
    }

    public function isAdmin()
    {
        return $this->hasRole('ADMIN');
    }
}
