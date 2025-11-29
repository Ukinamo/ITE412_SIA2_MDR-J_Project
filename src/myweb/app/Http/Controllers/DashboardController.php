<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\ScholarshipApplication;
use App\Models\ScholarshipProgram;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function userDashboard()
    {
        $user = Auth::user();
        
        $data = [
            'applications' => $user->applications()->with('program')->latest()->get(),
            'pendingApplications' => $user->applications()->where('status', 'pending')->count(),
            'approvedApplications' => $user->applications()->where('status', 'approved')->count(),
            'unreadMessages' => $user->receivedMessages()->where('is_read', false)->count(),
            'activePrograms' => ScholarshipProgram::where('is_active', true)
                ->where('deadline', '>', now())
                ->get()
        ];

        return view('user.dashboard.index', $data);
    }

    public function adminDashboard()
    {
        $data = [
            'totalApplications' => ScholarshipApplication::count(),
            'pendingApplications' => ScholarshipApplication::where('status', 'pending')->count(),
            'underReviewApplications' => ScholarshipApplication::where('status', 'under_review')->count(),
            'activePrograms' => ScholarshipProgram::where('is_active', true)->count(),
            'totalStudents' => User::where('role', 'user')->count(),
            'totalReviewers' => User::where('role', 'viewer')->count(),
            'recentApplications' => ScholarshipApplication::with(['user', 'program'])
                ->latest()
                ->limit(10)
                ->get(),
            'programs' => ScholarshipProgram::withCount(['applications', 'activeApplications'])->get()
        ];

        return view('admin.dashboard.index', $data);
    }

    public function viewerReports()
    {
        $user = Auth::user();
        
        $data = [
            'assignedApplications' => $user->assignedApplications()
                ->with(['user', 'program'])
                ->whereIn('status', ['under_review', 'pending'])
                ->get(),
            'completedEvaluations' => $user->evaluations()->count(),
            'pendingEvaluations' => $user->assignedApplications()
                ->whereIn('status', ['under_review', 'pending'])
                ->count(),
            'recentEvaluations' => $user->evaluations()
                ->with(['application.user', 'application.program'])
                ->latest()
                ->limit(5)
                ->get()
        ];

        return view('viewer.dashboard.index', $data);
    }
}