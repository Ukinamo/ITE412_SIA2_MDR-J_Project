<?php
// app/Http/Controllers/EvaluationController.php
namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\ScholarshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function create(ScholarshipApplication $application)
    {
        if ($application->assigned_to !== Auth::id()) {
            abort(403, 'You are not assigned to evaluate this application.');
        }

        return view('viewer.evaluations.create', compact('application'));
    }

    public function store(Request $request, ScholarshipApplication $application)
    {
        if ($application->assigned_to !== Auth::id()) {
            abort(403, 'You are not assigned to evaluate this application.');
        }

        $request->validate([
            'score' => 'required|integer|min:1|max:100',
            'comments' => 'required|string|min:5',
            'recommendation' => 'required|in:approve,reject,waitlist',
            'criteria_scores' => 'required|array'
        ]);

        Evaluation::create([
            'application_id' => $application->id,
            'reviewer_id' => Auth::id(),
            'score' => $request->score,
            'comments' => $request->comments,
            'criteria_scores' => $request->criteria_scores,
            'recommendation' => $request->recommendation,
        ]);

        if ($request->recommendation === 'approve') {
            $application->update(['status' => 'approved']);
        } elseif ($request->recommendation === 'reject') {
            $application->update(['status' => 'rejected']);
        }

        return redirect()->route('viewer.applications.index')
            ->with('success', 'Evaluation submitted successfully!');
    }

    public function myEvaluations()
    {
        $evaluations = Auth::user()->evaluations()
            ->with(['application.user', 'application.program'])
            ->latest()
            ->get();

        return view('viewer.evaluations.index', compact('evaluations'));
    }
}