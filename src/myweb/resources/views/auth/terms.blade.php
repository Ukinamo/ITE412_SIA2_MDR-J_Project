<!-- resources/views/auth/terms.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service & Privacy Policy - EduGrant Pro</title>
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
            background: var(--green-50);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .nav-brand {
            color: var(--green-700) !important;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .terms-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin: 2rem auto;
            overflow: hidden;
        }

        .terms-header {
            background: linear-gradient(135deg, var(--green-500), var(--green-700));
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .terms-content {
            padding: 3rem 2rem;
            max-height: 70vh;
            overflow-y: auto;
        }

        .section-title {
            color: var(--green-700);
            border-bottom: 2px solid var(--green-100);
            padding-bottom: 0.5rem;
            margin: 2rem 0 1rem 0;
            font-weight: 600;
        }

        .section-title:first-child {
            margin-top: 0;
        }

        .back-to-auth {
            background: var(--green-500);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .back-to-auth:hover {
            background: var(--green-600);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .highlight-box {
            background: var(--green-50);
            border-left: 4px solid var(--green-500);
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-radius: 0 8px 8px 0;
        }

        .contact-info {
            background: var(--green-100);
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }

        .scroll-indicator {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--green-500);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .scroll-indicator:hover {
            background: var(--green-600);
            transform: translateY(-2px);
        }

        .last-updated {
            background: var(--gray-200);
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: var(--gray-700);
        }

        @media (max-width: 768px) {
            .terms-content {
                padding: 2rem 1.5rem;
                max-height: 60vh;
            }
            
            .terms-header {
                padding: 2rem 1.5rem;
            }
        }

        /* Custom scrollbar */
        .terms-content::-webkit-scrollbar {
            width: 8px;
        }

        .terms-content::-webkit-scrollbar-track {
            background: var(--gray-200);
            border-radius: 4px;
        }

        .terms-content::-webkit-scrollbar-thumb {
            background: var(--green-300);
            border-radius: 4px;
        }

        .terms-content::-webkit-scrollbar-thumb:hover {
            background: var(--green-500);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand nav-brand" href="#">
                <i class="fas fa-graduation-cap me-2"></i>EduGrant Pro
            </a>
            <div class="navbar-nav ms-auto">
                <a href="{{ url()->previous() }}" class="back-to-auth">
                    <i class="fas fa-arrow-left me-2"></i>Back to Registration
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="terms-container">
                    <!-- Header -->
                    <div class="terms-header">
                        <i class="fas fa-file-contract fa-3x mb-3"></i>
                        <h1 class="fw-bold mb-3">Terms of Service & Privacy Policy</h1>
                        <p class="lead mb-0 opacity-90">Last Updated: December 1, 2024</p>
                    </div>

                    <!-- Content -->
                    <div class="terms-content">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Important:</strong> Please read these terms carefully before using EduGrant Pro. By creating an account, you agree to be bound by these terms.
                        </div>

                        <!-- Terms of Service -->
                        <h3 class="section-title">Terms of Service</h3>

                        <h5>1. Acceptance of Terms</h5>
                        <p>By accessing and using EduGrant Pro ("the Platform"), you accept and agree to be bound by the terms and provision of this agreement.</p>

                        <h5>2. Description of Service</h5>
                        <p>EduGrant Pro is a scholarship management platform that provides:</p>
                        <ul>
                            <li>Scholarship application submission and management for students</li>
                            <li>Application review and evaluation tools for reviewers</li>
                            <li>Comprehensive administration tools for scholarship program management</li>
                            <li>Communication features between all platform users</li>
                        </ul>

                        <h5>3. User Accounts</h5>
                        <p>When you create an account with us, you must provide accurate, complete, and current information. You are responsible for:</p>
                        <ul>
                            <li>Maintaining the confidentiality of your account and password</li>
                            <li>All activities that occur under your account</li>
                            <li>Notifying us immediately of any unauthorized use of your account</li>
                        </ul>

                        <div class="highlight-box">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                            <strong>Account Security:</strong> You are solely responsible for safeguarding your password and for any activities or actions under your password.
                        </div>

                        <h5>4. User Responsibilities</h5>
                        <p>As a user of EduGrant Pro, you agree to:</p>
                        <ul>
                            <li>Provide accurate and truthful information in all applications</li>
                            <li>Use the platform only for lawful purposes</li>
                            <li>Not engage in any fraudulent or malicious activities</li>
                            <li>Respect the confidentiality of other users' information</li>
                            <li>Not attempt to undermine the security or integrity of our systems</li>
                        </ul>

                        <h5>5. Intellectual Property</h5>
                        <p>The Platform and its original content, features, and functionality are owned by EduGrant Pro and are protected by international copyright, trademark, and other intellectual property laws.</p>

                        <h5>6. Termination</h5>
                        <p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>

                        <!-- Privacy Policy -->
                        <h3 class="section-title">Privacy Policy</h3>

                        <h5>1. Information We Collect</h5>
                        <p>We collect several different types of information for various purposes to provide and improve our service to you.</p>

                        <h6>Personal Data</h6>
                        <p>While using our platform, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you:</p>
                        <ul>
                            <li>Full name and contact information</li>
                            <li>Email address</li>
                            <li>Academic records and educational background</li>
                            <li>Financial information (for need-based scholarships)</li>
                            <li>Application essays and supporting documents</li>
                            <li>Evaluation data and reviewer comments</li>
                        </ul>

                        <h6>Usage Data</h6>
                        <p>We may also collect information on how the platform is accessed and used:</p>
                        <ul>
                            <li>IP address and browser type</li>
                            <li>Platform usage statistics and patterns</li>
                            <li>Time and date of visits</li>
                        </ul>

                        <h5>2. How We Use Your Information</h5>
                        <p>EduGrant Pro uses the collected data for various purposes:</p>
                        <ul>
                            <li>To provide and maintain the platform</li>
                            <li>To process scholarship applications</li>
                            <li>To facilitate communication between users</li>
                            <li>To provide analysis or valuable information to improve the platform</li>
                            <li>To monitor platform usage and detect technical issues</li>
                            <li>To fulfill any other purpose for which you provide it</li>
                        </ul>

                        <div class="highlight-box">
                            <i class="fas fa-shield-alt text-success me-2"></i>
                            <strong>Data Protection:</strong> We implement appropriate technical and organizational security measures to protect your personal data against unauthorized access, alteration, disclosure, or destruction.
                        </div>

                        <h5>3. Data Sharing and Disclosure</h5>
                        <p>We may share your information in the following situations:</p>
                        <ul>
                            <li><strong>With Scholarship Reviewers:</strong> Your application materials are shared with assigned reviewers for evaluation purposes</li>
                            <li><strong>With Educational Institutions:</strong> For scholarship programs administered by partner institutions</li>
                            <li><strong>For Legal Compliance:</strong> When required by law or to respond to valid legal process</li>
                            <li><strong>Service Providers:</strong> With trusted third parties who assist us in operating our platform</li>
                        </ul>

                        <h5>4. Data Retention</h5>
                        <p>We will retain your personal data only for as long as necessary for the purposes set out in this Privacy Policy. Scholarship application data is typically retained for 5 years for audit and reporting purposes.</p>

                        <h5>5. Your Data Protection Rights</h5>
                        <p>Depending on your location, you may have the following rights regarding your personal data:</p>
                        <ul>
                            <li>The right to access, update, or delete your information</li>
                            <li>The right of rectification for inaccurate or incomplete data</li>
                            <li>The right to object to our processing of your personal data</li>
                            <li>The right to data portability</li>
                            <li>The right to withdraw consent</li>
                        </ul>

                        <h5>6. Cookies and Tracking</h5>
                        <p>We use cookies and similar tracking technologies to track activity on our platform and hold certain information to improve user experience.</p>

                        <!-- Platform-Specific Policies -->
                        <h3 class="section-title">Platform-Specific Policies</h3>

                        <h5>1. Student Responsibilities</h5>
                        <p>As a student user, you agree to:</p>
                        <ul>
                            <li>Submit only accurate and truthful information</li>
                            <li>Not misrepresent your academic or personal achievements</li>
                            <li>Respect application deadlines and requirements</li>
                            <li>Maintain professional communication with reviewers and administrators</li>
                        </ul>

                        <h5>2. Reviewer Responsibilities</h5>
                        <p>As a reviewer, you agree to:</p>
                        <ul>
                            <li>Evaluate applications fairly and objectively</li>
                            <li>Maintain confidentiality of applicant information</li>
                            <li>Complete evaluations in a timely manner</li>
                            <li>Provide constructive and professional feedback</li>
                        </ul>

                        <h5>3. Administrator Responsibilities</h5>
                        <p>As an administrator, you agree to:</p>
                        <ul>
                            <li>Use platform access only for legitimate administrative purposes</li>
                            <li>Protect the confidentiality of all user data</li>
                            <li>Ensure fair and transparent scholarship processes</li>
                            <li>Comply with all applicable laws and regulations</li>
                        </ul>

                        <!-- Contact Information -->
                        <div class="contact-info">
                            <h5 class="text-success"><i class="fas fa-envelope me-2"></i>Contact Information</h5>
                            <p class="mb-1"><strong>For Privacy Concerns:</strong> privacy@edugrantpro.com</p>
                            <p class="mb-1"><strong>For Technical Support:</strong> support@edugrantpro.com</p>
                            <p class="mb-0"><strong>General Inquiries:</strong> info@edugrantpro.com</p>
                        </div>

                        <div class="last-updated">
                            <i class="fas fa-clock me-2"></i>
                            This document was last updated on December 1, 2024. We may update these terms from time to time, and we will notify users of any material changes.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <div class="scroll-indicator" onclick="scrollToTop()" id="scrollToTop" style="display: none;">
        <i class="fas fa-chevron-up"></i>
    </div>

    <script>
        // Show scroll to top button when scrolling down
        window.onscroll = function() {
            const scrollBtn = document.getElementById('scrollToTop');
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                scrollBtn.style.display = 'flex';
            } else {
                scrollBtn.style.display = 'none';
            }
        };

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Add print functionality
        function printTerms() {
            window.print();
        }

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.history.back();
            }
        });
    </script>
</body>
</html>