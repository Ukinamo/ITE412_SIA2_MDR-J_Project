<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduGrant Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --green-500: #4CAF50;
            --green-600: #43A047;
            --green-700: #388E3C;
            --green-300: #81C784;
            --green-100: #C8E6C9;
            --green-50: #E8F5E9;
            --gray-900: #212121;
            --gray-700: #616161;
            --gray-400: #BDBDBD;
            --gray-200: #EEEEEE;
        }

        body { 
            background: linear-gradient(135deg, var(--green-300) 0%, var(--gray-400) 100%);
            min-height: 100vh; 
            display: flex; 
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-card { 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            border: none;
            overflow: hidden;
        }

        .auth-header {
            background: linear-gradient(135deg, var(--green-500), var(--green-700));
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .auth-body {
            padding: 2.5rem 2rem;
        }

        .btn-primary { 
            background: linear-gradient(135deg, var(--green-500), var(--green-600));
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--green-600), var(--green-700));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 2px solid var(--gray-200);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--green-500);
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.1);
        }

        .form-check-input:checked {
            background-color: var(--green-500);
            border-color: var(--green-500);
        }

        .auth-divider {
            position: relative;
            text-align: center;
            margin: 2rem 0;
        }

        .auth-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gray-200);
        }

        .auth-divider span {
            background: white;
            padding: 0 1rem;
            color: var(--gray-700);
            font-size: 0.9rem;
        }

        .role-selector {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .role-option {
            flex: 1;
            text-align: center;
            padding: 1rem;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .role-option:hover {
            border-color: var(--green-300);
        }

        .role-option.active {
            border-color: var(--green-500);
            background: var(--green-50);
        }

        .role-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--green-500);
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-700);
            cursor: pointer;
        }

        .input-group {
            position: relative;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 1.5rem 0;
        }

        .feature-list li {
            padding: 0.5rem 0;
            color: var(--gray-200);
        }

        .feature-list li i {
            color: var(--gray-200);
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            .auth-body {
                padding: 2rem 1.5rem;
            }
            
            .role-selector {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card auth-card">
                    <div class="row g-0">
                        <!-- Left Side - Branding -->
                        <div class="col-md-6 d-none d-md-block">
                            <div class="auth-header h-100 d-flex flex-column justify-content-center">
                                <div class="mb-4">
                                    <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                                    <h2 class="fw-bold">EduGrant Pro</h2>
                                    <p class="mb-0 opacity-90">Scholarship Management System</p>
                                </div>
                                <div class="text-start">
                                    <h5 class="mb-3">Why Join Us?</h5>
                                    <ul class="feature-list">
                                        <li><i class="fas fa-check-circle"></i> Streamlined application process</li>
                                        <li><i class="fas fa-check-circle"></i> Real-time status tracking</li>
                                        <li><i class="fas fa-check-circle"></i> Secure document management</li>
                                        <li><i class="fas fa-check-circle"></i> Professional evaluation tools</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Side - Login Form -->
                        <div class="col-md-6">
                            <div class="auth-body">
                                <div class="text-center mb-4 d-md-none">
                                    <i class="fas fa-graduation-cap fa-2x text-success mb-2"></i>
                                    <h3 class="fw-bold text-success">EduGrant Pro</h3>
                                </div>

                                <h4 class="fw-bold mb-1">Welcome Back</h4>
                                <p class="text-muted mb-4">Sign in to continue your scholarship journey</p>

                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fas fa-check-circle me-2"></i>
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" 
                                                   placeholder="Enter your email" required autofocus>
                                            <span class="input-group-text bg-transparent border-0">
                                                <i class="fas fa-envelope text-muted"></i>
                                            </span>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label fw-semibold">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" placeholder="Enter your password" required>
                                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                            <label class="form-check-label" for="remember">Remember me</label>
                                        </div>
                                        <a href="#" class="text-decoration-none text-success fw-semibold">Forgot password?</a>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-3 mb-3">
                                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                    </button>

                                    <div class="auth-divider">
                                        <span>New to EduGrant Pro?</span>
                                    </div>

                                    <div class="text-center">
                                        <p class="mb-0">Don't have an account? 
                                            <a href="{{ route('register.form') }}" class="text-success fw-semibold text-decoration-none">Create account</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Add loading state to form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Signing In...';
            submitBtn.disabled = true;
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>