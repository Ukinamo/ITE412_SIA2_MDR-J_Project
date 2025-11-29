<?php
// app/Http/Controllers/ApplicationController.php
namespace App\Http\Controllers;

use App\Models\ScholarshipApplication;
use App\Models\ScholarshipProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'user') {
            return $this->myApplications();
        } elseif ($user->role === 'viewer') {
            return $this->viewerIndex();
        } elseif ($user->role === 'admin') {
            return $this->adminIndex();
        }

        return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
    }

    public function myApplications()
    {
        $applications = Auth::user()->applications()
            ->with(['program', 'assignee', 'evaluations.reviewer'])
            ->latest()
            ->get();

        return view('user.applications.index', compact('applications'));
    }

    public function adminIndex()
    {
        $applications = ScholarshipApplication::with(['user', 'program', 'assignee', 'evaluations.reviewer'])
            ->latest()
            ->get();

        $reviewers = User::where('role', 'viewer')->get();
        $students = User::where('role', 'user')->get();

        return view('admin.applications.index', compact('applications', 'reviewers', 'students'));
    }

    public function viewerIndex()
    {
        $applications = Auth::user()->assignedApplications()
            ->with(['user', 'program', 'evaluations.reviewer'])
            ->latest()
            ->get();

        return view('viewer.applications.index', compact('applications'));
    }

    public function create($programId)
    {
        $program = ScholarshipProgram::findOrFail($programId);
        
        if (!$program->is_open) {
            return redirect()->route('programs.index')->with('error', 'Application deadline has passed or program is inactive.');
        }

        $existingApplication = ScholarshipApplication::where('user_id', Auth::id())
            ->where('program_id', $programId)
            ->first();

        if ($existingApplication) {
            return redirect()->route('programs.index')->with('error', 'You have already applied for this scholarship.');
        }

        return view('user.applications.create', compact('program'));
    }

    public function store(Request $request, $programId)
    {
        $program = ScholarshipProgram::findOrFail($programId);

        $validated = $request->validate([
            'academic_records' => 'required|string|min:10',
            'financial_info' => 'required|string|min:50',
            'essay' => 'required|string|min:200',
            'recommendation_letter' => 'nullable|string|min:10',
            'cor_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'gwa_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'recommendation_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [
            'cor_file.required' => 'Certificate of Registration file is required.',
            'cor_file.mimes' => 'COR must be a PDF, JPG, JPEG, or PNG file.',
            'cor_file.max' => 'COR file must not exceed 10MB.',
            'gwa_file.required' => 'GWA proof file is required.',
            'gwa_file.mimes' => 'GWA proof must be a PDF, JPG, JPEG, or PNG file.',
            'gwa_file.max' => 'GWA proof file must not exceed 10MB.',
        ]);

        try {
            // Handle file uploads with unique filenames
            $corFile = $request->file('cor_file');
            $gwaFile = $request->file('gwa_file');
            
            // Generate unique filenames
            $corFileName = 'cor_' . Auth::id() . '_' . time() . '_' . Str::random(10) . '.' . $corFile->getClientOriginalExtension();
            $gwaFileName = 'gwa_' . Auth::id() . '_' . time() . '_' . Str::random(10) . '.' . $gwaFile->getClientOriginalExtension();

            // Store files
            $corFilePath = $corFile->storeAs('applications/cor', $corFileName, 'public');
            $gwaFilePath = $gwaFile->storeAs('applications/gwa', $gwaFileName, 'public');

            // Handle optional recommendation file
            $recommendationFilePath = null;
            if ($request->hasFile('recommendation_file') && $request->file('recommendation_file')->isValid()) {
                $recommendationFile = $request->file('recommendation_file');
                $recommendationFileName = 'recommendation_' . Auth::id() . '_' . time() . '_' . Str::random(10) . '.' . $recommendationFile->getClientOriginalExtension();
                $recommendationFilePath = $recommendationFile->storeAs('applications/recommendations', $recommendationFileName, 'public');
            }

            $applicationData = [
                'academic_records' => $validated['academic_records'],
                'financial_info' => $validated['financial_info'],
                'essay' => $validated['essay'],
                'recommendation_letter' => $validated['recommendation_letter'] ?? null,
            ];

            // Create the application - FIXED: Added file paths to create array
            ScholarshipApplication::create([
                'user_id' => Auth::id(),
                'program_id' => $programId,
                'application_data' => $applicationData,
                'cor_file_path' => $corFilePath, // ADD THIS
                'gwa_file_path' => $gwaFilePath, // ADD THIS
                'recommendation_file_path' => $recommendationFilePath, // ADD THIS
                'status' => 'pending',
                'submitted_at' => now()->toDateTimeString(),
            ]);

            return redirect()->route('user.dashboard')->with('success', 'Application submitted successfully!');

        } catch (\Exception $e) {
            // Clean up any uploaded files if application creation failed
            if (isset($corFilePath) && Storage::disk('public')->exists($corFilePath)) {
                Storage::disk('public')->delete($corFilePath);
            }
            if (isset($gwaFilePath) && Storage::disk('public')->exists($gwaFilePath)) {
                Storage::disk('public')->delete($gwaFilePath);
            }
            if (isset($recommendationFilePath) && Storage::disk('public')->exists($recommendationFilePath)) {
                Storage::disk('public')->delete($recommendationFilePath);
            }

            return redirect()->back()->with('error', 'Failed to submit application. Please try again.')->withInput();
        }
    }

    public function show(ScholarshipApplication $application)
    {
        $user = Auth::user();
        
        if ($user->role === 'user' && $application->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($user->role === 'viewer' && $application->assigned_to !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $application->load(['user', 'program', 'evaluations.reviewer', 'messages.sender']);
        
        // Return role-specific views
        if ($user->role === 'admin') {
            return view('admin.applications.show', compact('application'));
        } elseif ($user->role === 'viewer') {
            return view('viewer.applications.show', compact('application'));
        } else {
            return view('user.applications.show', compact('application'));
        }
    }

    public function downloadFile(ScholarshipApplication $application, $fileType)
    {
        $user = Auth::user();
        
        // Authorization checks
        if ($user->role === 'user' && $application->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($user->role === 'viewer' && $application->assigned_to !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $filePath = null;
        $fileName = '';

        switch ($fileType) {
            case 'cor':
                $filePath = $application->cor_file_path;
                $fileName = 'certificate_of_registration_' . $application->user->name . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
                break;
            case 'gwa':
                $filePath = $application->gwa_file_path;
                $fileName = 'gwa_proof_' . $application->user->name . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
                break;
            case 'recommendation':
                $filePath = $application->recommendation_file_path;
                $fileName = 'recommendation_letter_' . $application->user->name . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
                break;
            default:
                abort(404, 'File type not found.');
        }

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($filePath, $fileName);
    }

    public function assignReviewer(Request $request, ScholarshipApplication $application)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id'
        ]);

        $application->update([
            'assigned_to' => $request->reviewer_id,
            'status' => 'under_review'
        ]);

        return redirect()->back()->with('success', 'Application assigned to reviewer successfully.');
    }

    public function updateStatus(Request $request, ScholarshipApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected'
        ]);

        $application->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }

    public function manageUsers()
    {
        $users = User::whereIn('role', ['user', 'viewer'])
            ->withCount(['applications', 'evaluations'])
            ->latest()
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,viewer,admin'
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'User role updated successfully.');
    }

    public function adminShow(ScholarshipApplication $application)
    {
        $application->load(['user', 'program', 'evaluations.reviewer', 'messages.sender']);
        return view('admin.applications.show', compact('application'));
    }

    public function viewerShow(ScholarshipApplication $application)
    {
        if ($application->assigned_to !== Auth::id()) {
            abort(403, 'You are not assigned to evaluate this application.');
        }

        $application->load(['user', 'program', 'evaluations.reviewer', 'messages.sender']);
        return view('viewer.applications.show', compact('application'));
    }
}