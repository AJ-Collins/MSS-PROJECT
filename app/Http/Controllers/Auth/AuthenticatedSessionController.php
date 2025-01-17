<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

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
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'reg_no' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('reg_no', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'reg_no' => __('The provided credentials are incorrect.'),
            ]);
        }

        // Regenerate session to avoid session fixation
        $request->session()->regenerate();

        // Redirect to the intended location or a default route
        return redirect()->intended($this->redirectTo());
    }

    /**
     * Destroy an authenticated session (log out).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Add a flash message for debugging
        $request->session()->flash('status', 'Logged out successfully');

        return redirect()->route('login');
    }

    protected function redirectTo(): string
    {
        $user = Auth::user();

        if (!$user) {
            return '/login'; // Fallback to home if no user is authenticated
        }

        $roles = $user->roles->pluck('name');

        if ($roles->contains('admin')) {
            return route('admin.dashboard');
        } elseif ($roles->contains('reviewer')) {
            return route('reviewer.dashboard');
        } elseif ($roles->contains('user')) {
            return route('user.dashboard');
        }

        return route('login'); // Fallback to login if no specific role is found
    }
}
