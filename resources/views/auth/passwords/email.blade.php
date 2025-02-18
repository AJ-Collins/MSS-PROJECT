<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/logo-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/logo-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo/logo-180x180.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .reset-container {
            width: 100%;
            max-width: 450px;
            margin: 2rem auto;
            padding: 1rem;
        }
        .brand-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
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
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card .card-body {
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
            background-color: #3498db;
            border: none;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #2980b9;
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
        .reset-info {
            text-align: center;
            color: #718096;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        @media (max-width: 576px) {
            .reset-container {
                padding: 0.5rem;
                margin: 1rem auto;
            }
            .card .card-body {
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
    <div class="container reset-container">
        <div class="card">
            <div class="brand-header text-center">
                <h4>Reset Password</h4>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Send Password Reset Link
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
