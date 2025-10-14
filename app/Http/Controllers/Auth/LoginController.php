<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirection après connexion.
     */
    protected function redirectTo(): string
    {
        return '/home';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
