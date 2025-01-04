<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUM-MSS - Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-container {
            width: 100%;
            max-width: 500px;
            margin: 2rem auto;
            padding: 1rem;
        }
        .brand-header {
            background: linear-gradient(135deg,rgb(13, 135, 0) 0%,rgb(157, 161, 30) 100%);
            padding: 1rem;
            border-radius: 8px 8px 0 0;
            margin-bottom: 0;
        }
        .brand-header h4 {
            color: white;
            font-weight: 300;
            letter-spacing: 1px;
            margin: 0;
            font-size: 1.2rem;
        }
        .register-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .register-card .card-body {
            padding: 1.5rem;
        }
        .form-control {
            padding: 0.6rem;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            font-size: 0.9rem;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .btn-primary {
            background-color:rgb(150, 188, 152);
            border: none;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            width: 100%;
        }
        .btn-primary:hover {
            background-color:rgb(127, 162, 129);
        }
        .form-text {
            color: #718096;
            font-size: 0.8rem;
        }
        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
            color: #2c3e50;
        }
        .mb-3 {
            margin-bottom: 1rem !important;
        }
        .invalid-feedback {
            font-size: 0.8rem;
        }
        .login-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
        .login-link a {
            color: #3498db;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        @media (max-width: 576px) {
            .register-container {
                padding: 0.5rem;
                margin: 1rem auto;
            }
            .register-card .card-body {
                padding: 1rem;
            }
            .brand-header {
                padding: 0.8rem;
            }
            .brand-header h4 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container register-container">
        <div class="register-card card">
            <div class="brand-header text-center">
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
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name"
                               value="{{ old('name') }}"
                               required 
                               autocomplete="name"
                               placeholder="Enter your full name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
                        <div class="form-text">We'll never share your email with anyone else</div>
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