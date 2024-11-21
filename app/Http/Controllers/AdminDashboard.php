<?php

namespace App\Http\Controllers;

use App\User;

class AdminDashboard extends Controller
{
    public function users()
    {
        $users = User::paginate(30);

        return view('pages.users', compact('users'));
    }

    public function businesses()
    {
        $businesses = \App\Model\Business::paginate(30);

        return view('pages.businesses', compact('businesses'));
    }
}
