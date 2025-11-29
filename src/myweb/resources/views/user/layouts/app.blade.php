<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Scholarship System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            /* Professional Color Palette */
            --primary-50: #E8F5E9;
            --primary-100: #C8E6C9;
            --primary-200: #A5D6A7;
            --primary-300: #81C784;
            --primary-400: #66BB6A;
            --primary-500: #4CAF50;
            --primary-600: #43A047;
            --primary-700: #388E3C;
            --primary-800: #2E7D32;
            --primary-900: #1B5E20;
            
            --neutral-50: #FAFAFA;
            --neutral-100: #F5F5F5;
            --neutral-200: #EEEEEE;
            --neutral-300: #E0E0E0;
            --neutral-400: #BDBDBD;
            --neutral-500: #9E9E9E;
            --neutral-600: #757575;
            --neutral-700: #616161;
            --neutral-800: #424242;
            --neutral-900: #212121;
            
            --success: #4CAF50;
            --warning: #FF9800;
            --error: #F44336;
            --info: #2196F3;
            
            /* User-specific colors */
            --user-primary: var(--primary-500);
            --user-primary-dark: var(--primary-600);
            --user-primary-light: var(--primary-400);
            --user-bg-light: var(--neutral-50);
            
            /* Typography */
            --font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            --font-size-xs: 0.75rem;
            --font-size-sm: 0.875rem;
            --font-size-base: 1rem;
            --font-size-lg: 1.125rem;
            --font-size-xl: 1.25rem;
            --font-size-2xl: 1.5rem;
            --font-size-3xl: 1.875rem;
            
            /* Spacing */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-10: 2.5rem;
            --space-12: 3rem;
            
            /* Border Radius */
            --radius-sm: 0.25rem;
            --radius-base: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            
            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-base: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        body {
            font-family: var(--font-family);
            font-size: var(--font-size-base);
            line-height: 1.6;
            color: var(--neutral-800);
            background-color: var(--user-bg-light);
        }
        
        /* Sidebar Styles */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--user-primary) 0%, var(--user-primary-dark) 100%);
            box-shadow: var(--shadow-lg);
            position: fixed;
            width: 280px;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar.collapsed {
            width: 80px;
        }
        
        .sidebar.collapsed .sidebar-brand-text,
        .sidebar.collapsed .nav-section-label,
        .sidebar.collapsed .nav-link-text,
        .sidebar.collapsed .user-info,
        .sidebar.collapsed .role-badge {
            display: none;
        }
        
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: var(--space-4);
        }
        
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }
        
        .sidebar-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            padding: var(--space-6) var(--space-5);
        }
        
        .sidebar-brand {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: var(--font-size-xl);
        }
        
        .sidebar-brand i {
            font-size: var(--font-size-lg);
            margin-right: var(--space-3);
            flex-shrink: 0;
        }
        
        .sidebar-brand-text {
            transition: opacity 0.3s ease;
        }
        
        .role-badge {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-size: var(--font-size-xs);
            padding: var(--space-2) var(--space-4);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            font-weight: 500;
            margin-top: var(--space-2);
            transition: opacity 0.3s ease;
        }
        
        .role-badge i {
            font-size: 0.7rem;
            margin-right: var(--space-2);
        }
        
        .nav-section {
            margin-bottom: var(--space-6);
        }
        
        .nav-section-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: var(--font-size-xs);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0 var(--space-5);
            margin-bottom: var(--space-2);
            transition: opacity 0.3s ease;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            border-radius: var(--radius-md);
            margin: var(--space-1) var(--space-3);
            padding: var(--space-3) var(--space-4);
            transition: all 0.2s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            position: relative;
            text-decoration: none;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(4px);
        }
        
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            box-shadow: var(--shadow-sm);
        }
        
        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 60%;
            width: 3px;
            background: white;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: var(--space-3);
            font-size: var(--font-size-sm);
            text-align: center;
            flex-shrink: 0;
        }
        
        .nav-link-text {
            transition: opacity 0.3s ease;
        }
        
        .sidebar-footer {
            margin-top: auto;
            padding: var(--space-4);
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }
        
        .user-info {
            transition: opacity 0.3s ease;
        }
        
        /* Main Content Styles */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        
        .sidebar.collapsed + .main-content {
            margin-left: 80px;
        }
        
        .content-area {
            padding: var(--space-6);
        }
        
        .content-header {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-6);
            margin-bottom: var(--space-6);
            box-shadow: var(--shadow-base);
            border-left: 4px solid var(--user-primary);
        }
        
        .content-header h1 {
            font-size: var(--font-size-2xl);
            font-weight: 600;
            color: var(--neutral-900);
            margin-bottom: var(--space-2);
        }
        
        .content-header .subtitle {
            color: var(--neutral-600);
            font-size: var(--font-size-base);
            margin-bottom: 0;
        }
        
        .content-body {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-6);
            box-shadow: var(--shadow-base);
        }
        
        /* Top Navigation */
        .top-nav {
            background: white;
            padding: var(--space-4) var(--space-6);
            border-bottom: 1px solid var(--neutral-200);
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .nav-controls {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }
        
        .toggle-sidebar {
            background: none;
            border: none;
            color: var(--neutral-600);
            font-size: var(--font-size-lg);
            padding: var(--space-2);
            border-radius: var(--radius-md);
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .toggle-sidebar:hover {
            background: var(--neutral-100);
            color: var(--neutral-800);
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-base);
            transition: box-shadow 0.2s ease;
            margin-bottom: var(--space-6);
        }
        
        .card:hover {
            box-shadow: var(--shadow-md);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid var(--neutral-200);
            padding: var(--space-4) var(--space-5);
            border-radius: var(--radius-lg) var(--radius-lg) 0 0 !important;
        }
        
        .card-title {
            font-size: var(--font-size-lg);
            font-weight: 600;
            color: var(--neutral-900);
            margin-bottom: 0;
        }
        
        /* Buttons */
        .btn {
            border-radius: var(--radius-md);
            font-weight: 500;
            padding: var(--space-3) var(--space-5);
            transition: all 0.2s ease;
            border: none;
        }
        
        .btn-primary {
            background: var(--user-primary);
        }
        
        .btn-primary:hover {
            background: var(--user-primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }
        
        /* Application Status Cards */
        .application-status-card {
            border-left: 4px solid var(--user-primary);
            transition: all 0.2s ease;
        }
        
        .application-status-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .status-draft {
            border-left-color: var(--neutral-500);
        }
        
        .status-submitted {
            border-left-color: var(--info);
        }
        
        .status-under-review {
            border-left-color: var(--warning);
        }
        
        .status-approved {
            border-left-color: var(--success);
        }
        
        .status-rejected {
            border-left-color: var(--error);
        }
        
        /* Progress Indicators */
        .application-progress {
            height: 6px;
            border-radius: var(--radius-base);
            background: var(--neutral-200);
            overflow: hidden;
        }
        
        .progress-bar {
            background: var(--user-primary);
            transition: width 0.3s ease;
        }
        
        /* Quick Actions */
        .quick-action-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-5);
            box-shadow: var(--shadow-base);
            border-top: 4px solid var(--user-primary);
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        
        .quick-action-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: inherit;
            text-decoration: none;
        }
        
        .quick-action-icon {
            width: 50px;
            height: 50px;
            border-radius: var(--radius-lg);
            background: var(--primary-50);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--font-size-xl);
            color: var(--user-primary);
            margin-bottom: var(--space-4);
        }
        
        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: var(--space-5);
            box-shadow: var(--shadow-base);
            border-top: 4px solid var(--user-primary);
            transition: transform 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .stat-value {
            font-size: var(--font-size-3xl);
            font-weight: 700;
            color: var(--user-primary);
            line-height: 1;
        }
        
        .stat-label {
            color: var(--neutral-600);
            font-size: var(--font-size-sm);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        /* Program Cards */
        .program-card {
            border: 1px solid var(--neutral-200);
            border-radius: var(--radius-lg);
            transition: all 0.2s ease;
            overflow: hidden;
        }
        
        .program-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .program-header {
            background: linear-gradient(135deg, var(--user-primary) 0%, var(--user-primary-dark) 100%);
            color: white;
            padding: var(--space-5);
        }
        
        .deadline-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-base);
            font-size: var(--font-size-xs);
            font-weight: 600;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        @media (max-width: 576px) {
            .content-area {
                padding: var(--space-4);
            }
            
            .content-header,
            .content-body {
                padding: var(--space-4);
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="d-flex flex-column h-100">
            <div class="sidebar-header">
                <a href="{{ route('user.dashboard') }}" class="sidebar-brand">
                    <i class="fas fa-graduation-cap"></i>
                    <span class="sidebar-brand-text">Scholarship Portal</span>
                </a>
                <div class="role-badge">
                    <i class="fas fa-user-graduate"></i>
                    <span>Student</span>
                </div>
            </div>
            
            <nav class="nav flex-column flex-grow-1">
                <div class="nav-section">
                    <div class="nav-section-label">Navigation</div>
                    <a class="nav-link @if(Route::is('user.dashboard')) active @endif" href="{{ route('user.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                    <a class="nav-link @if(Route::is('applications.*')) active @endif" href="{{ route('applications.index') }}">
                        <i class="fas fa-file-alt"></i>
                        <span class="nav-link-text">My Applications</span>
                    </a>
                    <a class="nav-link @if(Route::is('programs.*')) active @endif" href="{{ route('programs.index') }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span class="nav-link-text">Available Programs</span>
                    </a>
                </div>
                
                    <!-- In user sidebar section -->
                    <div class="nav-section">
                        <div class="nav-section-label">Communication</div>
                        <a class="nav-link @if(Route::is('user.messages.*')) active @endif" href="{{ route('user.messages.index') }}">
                            <i class="fas fa-envelope"></i>
                            <span class="nav-link-text">Messages</span>
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="badge bg-warning ms-auto">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </div>
                 </nav>
            
            <div class="sidebar-footer">
                <div class="d-flex align-items-center mb-3 user-info">
                    <div class="flex-shrink-0">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-user text-muted"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="text-white fw-medium">{{ Auth::user()->name ?? 'Student User' }}</div>
                        <small class="text-white-50">{{ Auth::user()->email ?? 'student@university.edu' }}</small>
                    </div>
                </div>
                
                <a class="nav-link text-white bg-danger bg-opacity-20 mt-2" href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span class="nav-link-text">Logout</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <div class="top-nav">
            <div class="nav-controls">
                <button class="toggle-sidebar d-lg-none">
                    <i class="fas fa-bars"></i>
                </button>
                <button class="toggle-sidebar d-none d-lg-block">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="d-none d-md-block">
                    <h5 class="mb-0 text-dark">Student Dashboard</h5>
                    <small class="text-muted">Welcome back, {{ Auth::user()->name ?? 'Student' }}</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-4">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-2"></i>
                        {{ Auth::user()->name ?? 'Student' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>My Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-alt me-2"></i>Application History</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if(View::hasSection('header'))
                @yield('header')
            @else
                <div class="content-header">
                    <h1>@yield('title', 'Student Dashboard')</h1>
                    @if(View::hasSection('subtitle'))
                        <p class="subtitle">@yield('subtitle')</p>
                    @else
                        <p class="subtitle">Manage your scholarship applications and track your progress</p>
                    @endif
                </div>
            @endif
            
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const toggleButtons = document.querySelectorAll('.toggle-sidebar');
            const mobileToggle = document.querySelector('.toggle-sidebar.d-lg-none');
            
            // Toggle sidebar collapse
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (window.innerWidth >= 992) {
                        // Desktop: toggle collapsed state
                        sidebar.classList.toggle('collapsed');
                        const icon = this.querySelector('i');
                        if (sidebar.classList.contains('collapsed')) {
                            icon.className = 'fas fa-chevron-right';
                        } else {
                            icon.className = 'fas fa-chevron-left';
                        }
                    } else {
                        // Mobile: toggle visibility
                        sidebar.classList.toggle('mobile-open');
                    }
                });
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 992 && 
                    !sidebar.contains(event.target) && 
                    !mobileToggle.contains(event.target) &&
                    sidebar.classList.contains('mobile-open')) {
                    sidebar.classList.remove('mobile-open');
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('mobile-open');
                }
            });
        });
    </script>
</body>
</html>