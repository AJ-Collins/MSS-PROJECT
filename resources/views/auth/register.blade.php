<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUM-MSS - Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0D8700;
            --secondary-color: #9DA11E;
            --form-bg: #ffffff;
            --input-border: #e5e7eb;
            --text-primary: #374151;
            --text-secondary: #6B7280;
        }

        body {
            background-color: #f3f4f6;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }

        .register-container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            padding: 1.5rem;
        }

        .brand-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 1.5rem;
            border-radius: 12px 12px 0 0;
            text-align: center;
        }

        .brand-header h4 {
            color: white;
            font-weight: 500;
            letter-spacing: 0.5px;
            margin: 0;
            font-size: 1.5rem;
        }

        .register-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background: var(--form-bg);
        }

        .register-card .card-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1.5px solid var(--input-border);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(13, 135, 0, 0.1);
        }

        .form-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 0.875rem 1.5rem;
            font-weight: 500;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13, 135, 0, 0.2);
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .name-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .invalid-feedback {
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-secondary);
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .register-container {
                padding: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .name-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container register-container">
        <div class="register-card card">
            <div class="brand-header">
                <h4>Create New Account</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="reg_no" class="form-label">Registration Number</label>
                        <input type="text" 
                               class="form-control @error('reg_no') is-invalid @enderror" 
                               id="reg_no" 
                               name="reg_no"
                               value="{{ old('reg_no') }}"
                               required 
                               autocomplete="reg_no"
                               placeholder="Enter your registration number">
                        <div class="form-text">Your unique institutional registration number</div>
                        @error('reg_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="salutation" class="form-label">Salutation</label>
                        <select class="form-select @error('salutation') is-invalid @enderror" 
                                id="salutation" 
                                name="salutation">
                            <option value="">Select Salutation</option>
                            <option value="Mr." {{ old('salutation') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                            <option value="Mrs." {{ old('salutation') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                            <option value="Ms." {{ old('salutation') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                            <option value="Dr." {{ old('salutation') == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                            <option value="Prof." {{ old('salutation') == 'Prof.' ? 'selected' : '' }}>Prof.</option>
                        </select>
                        @error('salutation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="name-group mb-3">
                        <div>
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" 
                                   class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" 
                                   name="first_name"
                                   value="{{ old('first_name') }}"
                                   required 
                                   autocomplete="first_name"
                                   placeholder="Enter first name">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" 
                                   class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" 
                                   name="last_name"
                                   value="{{ old('last_name') }}"
                                   required 
                                   autocomplete="last_name"
                                   placeholder="Enter last name">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email"
                               value="{{ old('email') }}"
                               required 
                               autocomplete="email"
                               placeholder="Enter your email address">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password"
                               required 
                               autocomplete="new-password"
                               placeholder="Create a password">
                        <div class="form-text">Password must be at least 8 characters long</div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">Confirm Password</label>
                        <input type="password" 
                               class="form-control" 
                               id="password-confirm" 
                               name="password_confirmation"
                               required 
                               autocomplete="new-password"
                               placeholder="Confirm your password">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Create Account
                        </button>
                    </div>
                    
                    <div class="login-link">
                        Already have an account? <a href="{{ route('login') }}">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>