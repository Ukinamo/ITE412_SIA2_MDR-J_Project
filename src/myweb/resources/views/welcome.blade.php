<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Green Main Palette */
            --green-500: #4CAF50;
            --green-600: #43A047;
            --green-700: #388E3C;
            --green-300: #81C784;
            --green-100: #C8E6C9;
            --green-50: #E8F5E9;
            
            /* Neutral Grays */
            --gray-900: #212121;
            --gray-700: #616161;
            --gray-400: #BDBDBD;
            --gray-200: #EEEEEE;
            
            /* Alert Colors */
            --success: #2E7D32;
            --warning: #FBC02D;
            --danger: #D32F2F;
            
            /* Role Colors */
            --admin: #2E7D32;
            --viewer: #81C784;
            --user: #4CAF50;
        }

        .hero-section { 
            background: linear-gradient(135deg, var(--green-500) 0%, var(--green-700) 100%);
            color: white;
            padding: 120px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="1000,100 1000,0 0,100"/></svg>');
            background-size: cover;
        }

        .feature-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border-left: 4px solid var(--green-500);
            background: white;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--green-50), white);
            border: none;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .btn-primary {
            background: var(--green-500);
            border-color: var(--green-500);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--green-600);
            border-color: var(--green-600);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-outline-primary {
            border-color: var(--green-500);
            color: var(--green-500);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--green-500);
            border-color: var(--green-500);
            transform: translateY(-2px);
        }

        .nav-brand {
            color: var(--green-700) !important;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .role-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-admin { background: var(--admin); color: white; }
        .badge-viewer { background: var(--viewer); color: var(--gray-900); }
        .badge-user { background: var(--user); color: white; }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            background: var(--green-50);
            color: var(--green-500);
            font-size: 2rem;
        }

        .process-step {
            text-align: center;
            padding: 2rem;
            position: relative;
        }

        .process-step::after {
            content: '→';
            position: absolute;
            right: -20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--green-300);
            font-size: 2rem;
            font-weight: 300;
        }

        .process-step:last-child::after {
            display: none;
        }

        .testimonial-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-left: 4px solid var(--green-300);
        }

        .stats-section {
            background: linear-gradient(135deg, var(--green-50), var(--green-100));
        }

        @media (max-width: 768px) {
            .process-step::after {
                display: none;
            }
            
            .hero-section {
                padding: 80px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand nav-brand" href="#">
                <i class="fas fa-graduation-cap me-2"></i>EduGrant Pro
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link text-dark fw-medium me-3" href="#features">Features</a>
                    <a class="nav-link text-dark fw-medium me-3" href="#process">How It Works</a>
                    <a class="nav-link text-dark fw-medium me-3" href="#testimonials">Testimonials</a>
                    <a href="{{ route('login.form') }}" class="btn btn-outline-primary me-2">Login</a>
                    <a href="{{ route('register.form') }}" class="btn btn-primary">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Transform Scholarship Management with EduGrant Pro</h1>
                    <p class="lead mb-5 fs-5">A comprehensive platform that streamlines the entire scholarship lifecycle - from application to award distribution. Built for efficiency, transparency, and excellence.</p>
                    
                    <div class="row justify-content-center g-3">
                        <div class="col-md-4">
                            <a href="{{ route('register.form') }}" class="btn btn-light btn-lg w-100 fw-semibold">
                                <i class="fas fa-rocket me-2"></i>Start Your Journey
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="https://youtu.be/S5-ZQnjkFso" class="btn btn-outline-light btn-lg w-100 fw-semibold">
                                <i class="fas fa-play-circle me-2"></i>Watch Demo
                            </a>
                        </div>
                    </div>

                    <div class="row mt-5 pt-4">
                        <div class="col-md-3 col-6 text-center">
                            <h3 class="fw-bold display-6">500+</h3>
                            <p class="mb-0">Scholarships Managed</p>
                        </div>
                        <div class="col-md-3 col-6 text-center">
                            <h3 class="fw-bold display-6">10K+</h3>
                            <p class="mb-0">Students Served</p>
                        </div>
                        <div class="col-md-3 col-6 text-center">
                            <h3 class="fw-bold display-6">₱5M+</h3>
                            <p class="mb-0">Awards Distributed</p>
                        </div>
                        <div class="col-md-3 col-6 text-center">
                            <h3 class="fw-bold display-6">99%</h3>
                            <p class="mb-0">Satisfaction Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold mb-3">Comprehensive Platform for All Stakeholders</h2>
                    <p class="text-muted fs-5">Designed to meet the unique needs of every user in the scholarship ecosystem</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Student Features -->
                <div class="col-lg-4">
                    <div class="card feature-card h-100">
                        <div class="card-body p-4">
                            <div class="feature-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <span class="role-badge badge-user mb-3">For Students</span>
                            <h5 class="card-title fw-bold mb-3">Seamless Application Experience</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Easy online application process</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Real-time application tracking</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Document management system</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Automated status notifications</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Multiple scholarship applications</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Secure messaging with reviewers</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Admin Features -->
                <div class="col-lg-4">
                    <div class="card feature-card h-100">
                        <div class="card-body p-4">
                            <div class="feature-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <span class="role-badge badge-admin mb-3">For Administrators</span>
                            <h5 class="card-title fw-bold mb-3">Complete Management Control</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Program creation & management</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Application workflow automation</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Reviewer assignment & tracking</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Comprehensive analytics dashboard</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>User management & permissions</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Automated reporting system</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Reviewer Features -->
                <div class="col-lg-4">
                    <div class="card feature-card h-100">
                        <div class="card-body p-4">
                            <div class="feature-icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <span class="role-badge badge-viewer mb-3">For Reviewers</span>
                            <h5 class="card-title fw-bold mb-3">Efficient Evaluation Tools</h5>
                            <ul class="list-unstructured">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Structured evaluation forms</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Application comparison tools</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Collaborative review features</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Automated scoring system</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Progress tracking dashboard</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Secure communication channels</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section id="process" class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold mb-3">Streamlined Scholarship Process</h2>
                    <p class="text-muted fs-5">From application to award - every step optimized for efficiency</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row align-items-center">
                        <div class="col-lg-3 process-step">
                            <div class="stat-card">
                                <div class="feature-icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <h5>1. Apply</h5>
                                <p class="text-muted mb-0">Students submit applications with all required documents</p>
                            </div>
                        </div>
                        <div class="col-lg-3 process-step">
                            <div class="stat-card">
                                <div class="feature-icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <h5>2. Review</h5>
                                <p class="text-muted mb-0">Applications are assigned to reviewers for evaluation</p>
                            </div>
                        </div>
                        <div class="col-lg-3 process-step">
                            <div class="stat-card">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <h5>3. Evaluate</h5>
                                <p class="text-muted mb-0">Comprehensive scoring and ranking of applicants</p>
                            </div>
                        </div>
                        <div class="col-lg-3 process-step">
                            <div class="stat-card">
                                <div class="feature-icon">
                                    <i class="fas fa-award"></i>
                                </div>
                                <h5>4. Award</h5>
                                <p class="text-muted mb-0">Successful candidates receive scholarship awards</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-6 mb-4">
                    <div class="stat-card">
                        <i class="fas fa-clock fa-2x text-success mb-3"></i>
                        <h3 class="fw-bold">70% Faster</h3>
                        <p class="text-muted mb-0">Application Processing</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mb-4">
                    <div class="stat-card">
                        <i class="fas fa-chart-line fa-2x text-success mb-3"></i>
                        <h3 class="fw-bold">95% Accuracy</h3>
                        <p class="text-muted mb-0">In Evaluation Process</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mb-4">
                    <div class="stat-card">
                        <i class="fas fa-users fa-2x text-success mb-3"></i>
                        <h3 class="fw-bold">300+</h3>
                        <p class="text-muted mb-0">Institutions Trust Us</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mb-4">
                    <div class="stat-card">
                        <i class="fas fa-shield-alt fa-2x text-success mb-3"></i>
                        <h3 class="fw-bold">100% Secure</h3>
                        <p class="text-muted mb-0">Data Protection</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-5 bg-white">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold mb-3">Trusted by Educational Institutions</h2>
                    <p class="text-muted fs-5">What our users say about EduGrant Pro</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="testimonial-card h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="feature-icon" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold mb-0">Dr. Ramcis Jay Ramboanga</h6>
                                <small class="text-muted">Scholarship Recipient</small>
                            </div>
                        </div>
                        <p class="mb-0">"The application process was incredibly smooth. I could track my application status in real-time and the communication with reviewers was seamless."</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="feature-icon" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold mb-0">Dir. Miko Gomez</h6>
                                <small class="text-muted">University Administrator</small>
                            </div>
                        </div>
                        <p class="mb-0">"EduGrant Pro has revolutionized our scholarship management. We've reduced processing time by 70% and improved transparency across the board."</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="feature-icon" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold mb-0">Eng. Jonas Dela Rosa</h6>
                                <small class="text-muted">Scholarship Reviewer</small>
                            </div>
                        </div>
                        <p class="mb-0">"The evaluation tools are comprehensive and user-friendly. I can efficiently review applications and provide meaningful feedback to students."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5" style="background: linear-gradient(135deg, var(--green-500), var(--green-700));">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="text-white fw-bold mb-4">Ready to Transform Your Scholarship Management?</h2>
                    <p class="text-white mb-4 fs-5">Join hundreds of institutions already using EduGrant Pro to streamline their scholarship processes.</p>
                    <div class="row justify-content-center g-3">
                        <div class="col-md-4">
                            <a href="{{ route('register.form') }}" class="btn btn-light btn-lg w-100 fw-semibold">
                                <i class="fas fa-rocket me-2"></i>Get Started Free
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('login.form') }}" class="btn btn-outline-light btn-lg w-100 fw-semibold">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-graduation-cap me-2"></i>EduGrant Pro
                    </h5>
                    <p class="text-light">Transforming scholarship management through technology, transparency, and efficiency.</p>
                </div>
                <div class="col-lg-2 col-6 mb-4">
                    <h6 class="fw-bold mb-3">Platform</h6>
                    <ul class="list-unstyled">
                        <li><a href="#features" class="text-light text-decoration-none">Features</a></li>
                        <li><a href="#process" class="text-light text-decoration-none">How It Works</a></li>
                        <li><a href="#testimonials" class="text-light text-decoration-none">Testimonials</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6 mb-4">
                    <h6 class="fw-bold mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Help Center</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact Us</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Documentation</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h6 class="fw-bold mb-3">Get Started</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('register.form') }}" class="btn btn-success">Create Account</a>
                        <a href="{{ route('login.form') }}" class="btn btn-outline-light">Login</a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2024 EduGrant Pro. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>