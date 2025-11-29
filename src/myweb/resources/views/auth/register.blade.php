<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - EduGrant Pro</title>
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

        .role-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--gray-900);
        }

        .role-desc {
            font-size: 0.8rem;
            color: var(--gray-700);
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

        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 0.5rem;
            background: var(--gray-200);
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
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
                        <!-- Left Side - Registration Form -->
                        <div class="col-md-6">
                            <div class="auth-body">
                                <div class="text-center mb-4 d-md-none">
                                    <i class="fas fa-graduation-cap fa-2x text-success mb-2"></i>
                                    <h3 class="fw-bold text-success">EduGrant Pro</h3>
                                </div>

                                <h4 class="fw-bold mb-1">Create Account</h4>
                                <p class="text-muted mb-4">Join thousands managing scholarships efficiently</p>

                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Please check the form below for errors
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('register') }}" id="registerForm">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-semibold">Full Name</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" 
                                                   placeholder="Enter your full name" required autofocus>
                                            <span class="input-group-text bg-transparent border-0">
                                                <i class="fas fa-user text-muted"></i>
                                            </span>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" 
                                                   placeholder="Enter your email" required>
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
                                                   id="password" name="password" placeholder="Create a password" required
                                                   oninput="checkPasswordStrength()">
                                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="password-strength">
                                            <div class="password-strength-bar" id="passwordStrengthBar"></div>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" 
                                                   placeholder="Confirm your password" required
                                                   oninput="checkPasswordMatch()">
                                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="mt-1">
                                            <small id="passwordMatch" class="d-none text-success">
                                                <i class="fas fa-check-circle me-1"></i>Passwords match
                                            </small>
                                            <small id="passwordMismatch" class="d-none text-danger">
                                                <i class="fas fa-times-circle me-1"></i>Passwords do not match
                                            </small>
                                        </div>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="{{ route('terms') }}" class="text-success text-decoration-none">Terms of Service</a> and <a href="{{ route('terms') }}" class="text-success text-decoration-none">Privacy Policy</a>
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-3 mb-3" id="submitBtn">
                                        <i class="fas fa-user-plus me-2"></i>Create Account
                                    </button>

                                    <div class="auth-divider">
                                        <span>Already have an account?</span>
                                    </div>

                                    <div class="text-center">
                                        <p class="mb-0">Already registered? 
                                            <a href="{{ route('login.form') }}" class="text-success fw-semibold text-decoration-none">Sign in here</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Right Side - Branding -->
                        <div class="col-md-6 d-none d-md-block">
                            <div class="auth-header h-100 d-flex flex-column justify-content-center">
                                <div class="mb-4">
                                    <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                                    <h2 class="fw-bold">Join EduGrant Pro</h2>
                                    <p class="mb-0 opacity-90">Start your scholarship journey today</p>
                                </div>
                                <div class="text-start">
                                    <h5 class="mb-3">Benefits Include:</h5>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-rocket me-2 text-success"></i> Fast application process</li>
                                        <li class="mb-2"><i class="fas fa-shield-alt me-2 text-success"></i> Secure platform</li>
                                        <li class="mb-2"><i class="fas fa-clock me-2 text-success"></i> Real-time updates</li>
                                        <li class="mb-2"><i class="fas fa-chart-line me-2 text-success"></i> Track your progress</li>
                                        <li class="mb-0"><i class="fas fa-award me-2 text-success"></i> Increase success rate</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Role selection
        document.querySelectorAll('.role-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.role-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('role').value = this.dataset.role;
            });
        });

        // Password toggle
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = passwordInput.parentNode.querySelector('.password-toggle i');
            
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

        // Password strength checker
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('passwordStrengthBar');
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
            if (password.match(/\d/)) strength += 25;
            if (password.match(/[^a-zA-Z\d]/)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            if (strength < 50) {
                strengthBar.style.background = '#D32F2F'; // Red
            } else if (strength < 75) {
                strengthBar.style.background = '#FBC02D'; // Yellow
            } else {
                strengthBar.style.background = '#2E7D32'; // Green
            }
        }

        // Password match checker
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const match = document.getElementById('passwordMatch');
            const mismatch = document.getElementById('passwordMismatch');
            
            if (confirmPassword === '') {
                match.classList.add('d-none');
                mismatch.classList.add('d-none');
            } else if (password === confirmPassword) {
                match.classList.remove('d-none');
                mismatch.classList.add('d-none');
            } else {
                match.classList.add('d-none');
                mismatch.classList.remove('d-none');
            }
        }

        // Form submission loading state
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating Account...';
            submitBtn.disabled = true;
        });

        // Real-time validation
        document.getElementById('password').addEventListener('input', checkPasswordMatch);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>