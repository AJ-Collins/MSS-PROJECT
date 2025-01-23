<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleSwitcher extends Controller
{
    public function switchRole(Request $request)
    {
        // Validate the role
        $request->validate([
            'role' => [
                'required', 
                function ($attribute, $value, $fail) {
                    $userRoles = auth()->user()->roles->pluck('name')->toArray();
                    if (!in_array($value, $userRoles)) {
                        $fail("You do not have permission to switch to this role.");
                    }
                }
            ]
        ]);
    
        // Get the requested role
        $role = $request->input('role');
    
        // Update session with new role
        session(['current_role' => $role]);
    
        // Determine redirect route
        $redirectRoute = match($role) {
            'admin' => route('admin.dashboard'),
            'reviewer' => route('reviewer.dashboard'),
            'user' => route('user.dashboard'),
            default => route('dashboard')
        };
        // Return JSON response
        return response()->json([
            'success' => true,
            'message' => "Switched to {$role} role",
            'redirect' => $redirectRoute
        ]);
    }
}