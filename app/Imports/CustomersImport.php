<?php

namespace App\Imports;

use App\Model\Customer;
use App\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    protected $business;

    public function __construct($business)
    {
        $this->business = $business;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::where('email', $row['email'])->first();
        if ( is_null($user) ) {
            $user = User::where('phone', $row['phone'])->first();
        }

        if ( is_null($user) ) {
            $user = User::create([
                'name'      => $row['name'],
                'email'     => $row['email'],
                'phone'     => $row['phone'],
                'password'  => bcrypt(Str::random())
            ]);
        }

        return $this->business->customers()->firstOrCreate(['user_id' => $user->id]);
    }
}
