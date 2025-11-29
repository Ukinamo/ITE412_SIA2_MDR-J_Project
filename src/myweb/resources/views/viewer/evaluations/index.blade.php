<!-- resources/views/viewer/evaluations/index.blade.php -->
@extends('viewer.layouts.app')

@section('title', 'My Evaluations')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-star me-2"></i>My Evaluation History</h4>
    <a href="{{ route('viewer.applications.index') }}" class="btn btn-outline-warning">
        <i class="fas fa-tasks me-2"></i>Assigned Applications
    </a>
</div>

@if($evaluations->count() > 0)
<div class="card border-warning">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Completed Evaluations</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Program</th>
                        <th>Score</th>
                        <th>Recommendation</th>
                        <th>Application Status</th>
                        <th>Evaluated Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluations as $evaluation)
                    <tr>
                        <td>
                            <strong>{{ $evaluation->application->user->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $evaluation->application->user->email }}</small>
                        </td>
                        <td>{{ $evaluation->application->program->name }}</td>
                        <td>
                            <span class="badge 
                                @if($evaluation->score >= 80) bg-success
                                @elseif($evaluation->score >= 60) bg-warning
                                @else bg-danger @endif">
                                {{ $evaluation->score }}/100
                            </span>
                        </td>
                        <td>
                            <span class="badge 
                                @if($evaluation->recommendation == 'approve') bg-success
                                @elseif($evaluation->recommendation == 'reject') bg-danger
                                @else bg-warning @endif">
                                {{ ucfirst($evaluation->recommendation) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge 
                                @if($evaluation->application->status == 'approved') bg-success
                                @elseif($evaluation->application->status == 'rejected') bg-danger
                                @elseif($evaluation->application->status == 'under_review') bg-warning
                                @else bg-secondary @endif">
                                {{ ucfirst($evaluation->application->status) }}
                            </span>
                        </td>
                        <td>{{ $evaluation->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('applications.show', $evaluation->application) }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="text-center py-5">
    <i class="fas fa-star fa-4x text-muted mb-3"></i>
    <h5 class="text-muted">You haven't completed any evaluations yet.</h5>
    <p class="text-muted">Evaluations will appear here once you submit them.</p>
    <a href="{{ route('viewer.applications.index') }}" class="btn btn-warning">
        <i class="fas fa-tasks me-2"></i>View Assigned Applications
    </a>
</div>
@endif
@endsection