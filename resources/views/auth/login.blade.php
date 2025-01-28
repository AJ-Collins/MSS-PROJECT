<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TUM-MSS - Login</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/logo-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/logo-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo/logo-180x180.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
            border-radius: 0.375rem;
            background: rgb(220, 234, 248);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 1rem;
            transition: all 0.2s ease-in-out;
            background: transparent;
        }

        .password-input {
            padding-right: 2.5rem;
        }

        .form-label {
            position: absolute;
            left: 0.75rem;
            top: 0.75rem;
            padding: 0 0.25rem;
            color: #4a5568;
            font-size: 1rem;
            transition: all 0.2s ease-in-out;
            pointer-events: none;
        }

        .form-control:focus + .form-label,
        .form-control:not(:placeholder-shown) + .form-label {
            top: -0.5rem;
            left: 0.5rem;
            font-size: 0.875rem;
            color: #1f2937;
            background-color: rgb(239, 239, 239); /* Match the form-group background */
            padding: 0 0.5rem; /* Add some padding to fully cover the border */
        }

        .form-control:focus + .form-label,
        .form-control:not(:placeholder-shown) + .form-label {
            top: -0.5rem;
            left: 0.5rem;
            font-size: 0.875rem;
            color: #1f2937;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #4a5568;
            padding: 0.25rem;
        }

        .password-toggle:hover {
            color: #4f46e5;
        }

        .custom-green {
            background: #097B3E !important;
        }

        .custom-button {
            background: #E4F1C5;
            transition: background-color 300ms;
        }

        .custom-button:hover {
            background: #D1E7B4;
        }

        .custom-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="h-screen flex">
    <div class="flex w-full h-full">
        <!-- Left Information Panel -->
        <div class="hidden md:block md:w-1/2 text-white p-12 flex flex-col justify-center custom-green">
            <img src="/logo/logo.png" alt="TUM Logo" class="w-48 mx-auto mb-8">
            <h2 class="text-xl lg:text-2xl font-bold text-center mb-4 lg:mb-6">
                Technical University of Mombasa
            </h2>
            <p class="text-lg lg:text-xl font-bold text-center mb-4 lg:mb-6">
                Manuscript Submission System
            </p>
            
            <div class="space-y-6">
                <div class="flex items-center space-x-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="text-xl">Start a Submission</span>
                </div>
                <div class="flex items-center space-x-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                    <span class="text-xl">Continue Submission</span>
                </div>
                <div class="flex items-center space-x-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xl">Track Submission Progress</span>
                </div>
            </div>
        </div>

        <!-- Right Login Panel -->
        <div class="w-full md:w-3/2 bg-gray-100 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <form method="POST" action="{{ route('login') }}" class="bg-gray-100 px-10 pt-8 pb-10">
                @csrf
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-center text-gray-700 mb-2">SIGN IN | TUM-MSS</h2>
                        <p class="text-center text-gray-600">Welcome! Log in to access your dashboard.</p>
                    </div>
                    <div class="form-group">
                        <input 
                        type="text" 
                        class="form-control @error('reg_no') is-invalid @enderror" 
                        id="reg_no" 
                        name="reg_no" 
                        autofocus
                        placeholder=" " 
                        required>
                        @error('reg_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for="reg_no" class="form-label">USERNAME</label>
                    </div>

                    <div class="form-group">
                        <input 
                        type="password" 
                        class="password-input form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        placeholder=" " 
                        required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for="password" class="form-label">PASSWORD</label>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input 
                            id="remember"
                            name="remember"
                            type="checkbox" 
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-900">
                                Keep me signed in
                            </label>
                        </div>
                        <div>
                            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500 custom-link">
                                Forgot password?
                            </a>
                        </div>
                    </div>

                    <div>
                        <button 
                        type="submit" 
                        class="w-full custom-button text-black py-3 font-bold rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Sign in
                        </button>
                    </div>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 custom-link">
                                Create an account
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>
</body>
</html>
