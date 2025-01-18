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

        if (!Auth::attempt($request->only('reg_no', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'reg_no' => __('validation.auth.failed'),
            ]);
        }

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
