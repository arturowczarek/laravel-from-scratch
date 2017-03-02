<?php

namespace App\Http\Controllers;

use App\Mail\Welcome;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('registration.create');
    }

    public function store()
    {
        $this->validate(request(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed'
            ]
        );

        $user = User::create(request(['name', 'email', 'password']));
        auth()->login($user);

        Mail::to($user)->send(new Welcome($user));

        return redirect()->home();
    }
}
