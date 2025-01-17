<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Role;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function username()
    {
        return 'reg_no';
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->load('roles');
        $roles = $user->roles->pluck('name');

        if ($roles->contains('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($roles->contains('reviewer')) {
            return redirect()->route('reviewer.dashboard');
        } elseif ($roles->contains('user')) {
            return redirect()->route('user.dashboard');
        }

        return redirect()->route('login'); // Default fallback
    }

    public function redirectAfterLogin()
    {
        $lastVisitedUrl = session('last_visited_url', route('home')); // Default to home if no session data
        return redirect()->to($lastVisitedUrl);
    }
}