<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUM-MSS - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            padding: 1rem;
        }
        .brand-header {
            background: linear-gradient(135deg,rgb(13, 135, 0) 0%,rgb(157, 161, 30) 100%);
            padding: 1rem;
            border-radius: 8px 8px 0 0;
            margin-bottom: 0;
        }
        .brand-header h4 {
            color: black;
            font-weight: 400;
            letter-spacing: 1px;
            margin: 0;
            font-size: 1.2rem;
        }
        .login-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .login-card .card-body {
            padding: 1.5rem;
        }
        .form-control {
            padding: 0.6rem;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
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
        }
        .btn-primary:hover {
            background-color:rgb(127, 162, 129);
        }
        .login-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 1rem;
            margin-top: 1.5rem;
        }
        .form-text {
            color: #718096;
            font-size: 0.8rem;
        }
        .help-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
            font-size: 0.9rem;
        }
        .help-links a {
            color: #3498db;
            text-decoration: none;
        }
        .help-links a:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }
        .mb-4 {
            margin-bottom: 1rem !important;
        }
        @media (max-width: 576px) {
            .login-container {
                padding: 0.5rem;
            }
            .login-card .card-body {
                padding: 1rem;
            }
            .brand-header {
                padding: 0.8rem;
            }
            .brand-header h4 {
                font-size: 1.1rem;
            }
            .help-links {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="login-card card">
            <div class="brand-header text-center">
                <h4>Sign In | TUM-MSS</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="reg_no" class="form-label">Registration Number</label>
                        <input type="text" 
                               class="form-control" 
                               id="reg_no" 
                               name="reg_no"
                               required 
                               autocomplete="reg_no" 
                               autofocus
                               placeholder="Enter registration number">
                        <div class="form-text">Please enter your assigned registration number</div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password"
                               required
                               placeholder="Enter password">
                        <div class="form-text">Enter your secure password</div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="remember" 
                                   name="remember">
                            <label class="form-check-label" for="remember">
                                Keep me signed in
                            </label>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Sign In
                        </button>
                    </div>

                    <div class="login-footer">
                        <div class="help-links">
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                            <a href="{{ route('register') }}">New User Registration</a>
                            <!--<a href="#">Help</a>-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>