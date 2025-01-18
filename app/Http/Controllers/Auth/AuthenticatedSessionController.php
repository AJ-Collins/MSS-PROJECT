<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reg_no' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!$user = \App\Models\User::where('reg_no', $request->input('reg_no'))->first()) {
            // Case 1: Registration number doesn't exist
            throw ValidationException::withMessages([
                'reg_no' => __('No user found with this registration number'),
            ]);
        }
        
        if (!\Hash::check($request->input('password'), $user->password)) {
            // Case 2: Password is incorrect
            throw ValidationException::withMessages([
                'password' => __('Wrong password'),
            ]);
        }
        
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();
        $request->session()->flash('status', 'Login successful');

        return redirect()->intended($this->redirectTo());
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->flash('status', 'Logged out successfully');

        return redirect()->route('login');
    }

    protected function redirectTo(): string
    {
        $user = Auth::user();

        if (!$user) {
            return '/login';
        }

        if ($user->hasRole('admin')) {
            return route('admin.dashboard');
        } elseif ($user->hasRole('reviewer')) {
            return route('reviewer.dashboard');
        }

        return route('user.dashboard');
    }
}
