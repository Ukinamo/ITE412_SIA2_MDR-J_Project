<!-- resources/views/viewer/applications/index.blade.php -->
@extends('viewer.layouts.app')

@section('title', 'Assigned Applications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-tasks me-2"></i>My Assigned Applications</h4>
    <a href="{{ route('viewer.report') }}" class="btn btn-outline-warning">
        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
    </a>
</div>

@if($applications->count() > 0)
<div class="card border-warning">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Applications for Evaluation</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Program</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Evaluations</th>
                        <th>Assigned Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                    <tr>
                        <td>
                            <strong>{{ $application->user->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $application->user->email }}</small>
                        </td>
                        <td>{{ $application->program->name }}</td>
                        <td>${{ number_format($application->program->amount, 2) }}</td>
                        <td>
                            <span class="badge 
                                @if($application->status == 'approved') bg-success
                                @elseif($application->status == 'rejected') bg-danger
                                @elseif($application->status == 'under_review') bg-warning
                                @else bg-secondary @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $application->evaluations->count() }}</span>
                        </td>
                        <td>{{ $application->updated_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('applications.show', $application) }}" class="btn btn-outline-warning">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                @if(!$application->has_evaluation)
                                <a href="{{ route('evaluations.create', $application) }}" class="btn btn-warning">
                                    <i class="fas fa-star"></i> Evaluate
                                </a>
                                @endif
                            </div>
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
    <i class="fas fa-tasks fa-4x text-muted mb-3"></i>
    <h5 class="text-muted">No applications assigned to you yet.</h5>
    <p class="text-muted">Applications will appear here once assigned by an administrator.</p>
</div>
@endif
@endsection