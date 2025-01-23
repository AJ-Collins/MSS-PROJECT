<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function username()
    {
        return 'reg_no';
    }

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
        // Load the user's roles and set the first role as the default
        $user->load('roles');
        $roles = $user->roles->pluck('name');

        // Set the default role in the session
        session(['current_role' => $roles->first()]);

        // Redirect based on the user's role
        $currentRole = $user->getCurrentRole();

        return match($currentRole) {
            'admin' => redirect()->route('admin.dashboard'),
            'reviewer' => redirect()->route('reviewer.dashboard'),
            'user' => redirect()->route('user.dashboard'),
            default => redirect()->route('login'),
        };
    }

    /**
     * Redirect the user after login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectAfterLogin()
    {
        // If last visited URL is available in the session, use it, otherwise default to the dashboard
        $lastVisitedUrl = session('last_visited_url', route('dashboard')); 
        return redirect()->to($lastVisitedUrl);
    }
}
