<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        // Validate the incoming request data
        $this->validator($request->all())->validate();

        // Create the user but do not log them in
        $this->create($request->all());

        // Redirect to the login page with a success message
        return redirect()->route('login')->with('status', 'Registration successful. Please log in.');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'reg_no' => ['required', 'string', 'max:255', 'unique:users'],
            'salutation' => 'required|string|in:Mr.,Mrs.,Ms.,Dr.,Prof.',
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&]/', 'confirmed'],
        ],[
            'password.min' => 'The password must be at least 8 characters long.',
            'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);
    }

    /**
     * Create a new user instance.
     */
    protected function create(array $data)
    {
        $user = User::create([
            'reg_no' => $data['reg_no'],
            'salutation' => $data['salutation'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $role = DB::table('roles')->where('name', 'user')->first();
        if($role) {
            DB::table('role_user')->insert([
                'role_id' => $role->id,
                'reg_no' => $user->reg_no,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $user;

    }
}
