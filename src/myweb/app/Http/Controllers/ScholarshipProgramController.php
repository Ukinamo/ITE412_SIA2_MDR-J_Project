<?php
// app/Http/Controllers/ScholarshipProgramController.php
namespace App\Http\Controllers;

use App\Models\ScholarshipProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ScholarshipProgramController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return $this->adminIndex();
        }
        
        $programs = ScholarshipProgram::where('is_active', true)
            ->where('deadline', '>', now())
            ->latest()
            ->get();

        if ($user->role === 'viewer') {
            return view('viewer.programs.index', compact('programs'));
        } else {
            return view('user.programs.index', compact('programs'));
        }
    }

    public function adminIndex()
    {
        $programs = ScholarshipProgram::withCount('applications')
            ->latest()
            ->get();

        return view('admin.programs.index', compact('programs'));
    }

    public function show(ScholarshipProgram $program)
    {
        $user = Auth::user();
        
        $hasApplied = false;
        if ($user->role === 'user') {
            $hasApplied = $user->applications()
                ->where('program_id', $program->id)
                ->exists();
        }

        if ($user->role === 'admin') {
            return view('admin.programs.show', compact('program'));
        } elseif ($user->role === 'viewer') {
            return view('viewer.programs.show', compact('program'));
        } else {
            return view('user.programs.show', compact('program', 'hasApplied'));
        }
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'deadline' => 'required|date|after:today',
            'requirements' => 'required|array|min:1',
            'requirements.*.key' => 'required|string|max:255',
            'requirements.*.value' => 'required|string|max:500',
            'is_active' => 'sometimes|boolean'
        ], [
            'requirements.required' => 'At least one requirement is required.',
            'requirements.min' => 'At least one requirement is required.',
            'requirements.*.key.required' => 'Requirement name is required.',
            'requirements.*.value.required' => 'Requirement value is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $requirements = [];
        $validRequirementsCount = 0;

        foreach ($validated['requirements'] as $index => $requirement) {
            $key = trim($requirement['key'] ?? '');
            $value = trim($requirement['value'] ?? '');
            
            if (!empty($key) && !empty($value)) {
                $requirements[$key] = $value;
                $validRequirementsCount++;
            }
        }

        if ($validRequirementsCount === 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'At least one valid requirement with both name and value is required.');
        }

        try {
            ScholarshipProgram::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'deadline' => $validated['deadline'],
                'requirements' => $requirements,
                'is_active' => $request->boolean('is_active', true),
            ]);

            return redirect()->route('admin.programs.index')
                ->with('success', 'Scholarship program created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create scholarship program. Please try again.');
        }
    }

    public function edit(ScholarshipProgram $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, ScholarshipProgram $program)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'deadline' => 'required|date|after:today',
            'requirements' => 'required|array|min:1',
            'requirements.*.key' => 'required|string|max:255',
            'requirements.*.value' => 'required|string|max:500',
            'is_active' => 'sometimes|boolean'
        ], [
            'requirements.required' => 'At least one requirement is required.',
            'requirements.min' => 'At least one requirement is required.',
            'requirements.*.key.required' => 'Requirement name is required.',
            'requirements.*.value.required' => 'Requirement value is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $requirements = [];
        $validRequirementsCount = 0;

        foreach ($validated['requirements'] as $requirement) {
            $key = trim($requirement['key'] ?? '');
            $value = trim($requirement['value'] ?? '');
            
            if (!empty($key) && !empty($value)) {
                $requirements[$key] = $value;
                $validRequirementsCount++;
            }
        }

        if ($validRequirementsCount === 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'At least one valid requirement with both name and value is required.');
        }

        try {
            $program->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'deadline' => $validated['deadline'],
                'requirements' => $requirements,
                'is_active' => $request->boolean('is_active', true),
            ]);

            return redirect()->route('admin.programs.index', $program)
                ->with('success', 'Scholarship program updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update scholarship program. Please try again.');
        }
    }

    public function destroy(ScholarshipProgram $program)
    {
        try {
            if ($program->applications()->exists()) {
                return redirect()->back()
                    ->with('error', 'Cannot delete program that has applications. Please deactivate it instead.');
            }

            $program->delete();

            return redirect()->route('admin.programs.index')
                ->with('success', 'Scholarship program deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete scholarship program. Please try again.');
        }
    }

    public function toggleStatus(ScholarshipProgram $program)
    {
        try {
            $program->update([
                'is_active' => !$program->is_active
            ]);

            $status = $program->is_active ? 'activated' : 'deactivated';

            return redirect()->back()
                ->with('success', "Scholarship program {$status} successfully!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update program status. Please try again.');
        }
    }
}