<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Destroy an authenticated session (log out).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Log the user out
        Auth::guard('web')->logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect the user to the homepage or another route after logout
        return redirect('/');
    }

    protected function redirectTo(): string
    {
        $user = Auth::user();
        $user->load('roles');
        $roles = $user->roles->pluck('name');

        if (!$user) {
            return '/'; // Fallback to home if no user is authenticated
        }

        if ($roles->contains('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($roles->contains('reviewer')) {
            return redirect()->route('reviewer.partials.dashboard');
        } elseif ($roles->contains('user')) {
            return redirect()->route('user.dashboard');
        }

        return redirect()->route('login');
    }
}
