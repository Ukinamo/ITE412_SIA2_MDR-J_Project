<!-- resources/views/viewer/dashboard/index.blade.php -->
@extends('viewer.layouts.app')

@section('title', 'Reviewer Dashboard')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h2 class="card-title">{{ $assignedApplications->count() }}</h2>
                <p class="card-text">Assigned Applications</p>
                <i class="fas fa-tasks fa-2x"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h2 class="card-title">{{ $completedEvaluations }}</h2>
                <p class="card-text">Completed Evaluations</p>
                <i class="fas fa-check-circle fa-2x"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h2 class="card-title">{{ $pendingEvaluations }}</h2>
                <p class="card-text">Pending Evaluations</p>
                <i class="fas fa-clock fa-2x"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Assigned Applications</h5>
            </div>
            <div class="card-body">
                @if($assignedApplications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Program</th>
                                    <th>Status</th>
                                    <th>Assigned Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignedApplications as $application)
                                <tr>
                                    <td>{{ $application->user->name }}</td>
                                    <td>{{ $application->program->name }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($application->status == 'approved') bg-success
                                            @elseif($application->status == 'rejected') bg-danger
                                            @elseif($application->status == 'under_review') bg-warning
                                            @else bg-secondary @endif">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $application->updated_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('applications.show', $application) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        @if(!$application->has_evaluation)
                                        <a href="{{ route('evaluations.create', $application) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-star"></i> Evaluate
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No applications assigned to you yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-star me-2"></i>Recent Evaluations</h5>
            </div>
            <div class="card-body">
                @if($recentEvaluations->count() > 0)
                    @foreach($recentEvaluations as $evaluation)
                    <div class="mb-3 p-3 border rounded">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0">{{ $evaluation->application->program->name }}</h6>
                            <span class="badge bg-primary">{{ $evaluation->score }}/100</span>
                        </div>
                        <p class="small text-muted mb-1">Student: {{ $evaluation->application->user->name }}</p>
                        <p class="small mb-2">{{ Str::limit($evaluation->comments, 60) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $evaluation->created_at->format('M d, Y') }}</small>
                            <span class="badge 
                                @if($evaluation->recommendation == 'approve') bg-success
                                @elseif($evaluation->recommendation == 'reject') bg-danger
                                @else bg-warning @endif">
                                {{ ucfirst($evaluation->recommendation) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                    <div class="text-center mt-3">
                        <a href="{{ route('evaluations.my') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-list me-2"></i>View All Evaluations
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-star fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No evaluations submitted yet.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Evaluation Statistics</h5>
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-4">
                        <h4 class="text-success">{{ $completedEvaluations }}</h4>
                        <small>Completed</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-warning">{{ $pendingEvaluations }}</h4>
                        <small>Pending</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-primary">{{ $assignedApplications->count() }}</h4>
                        <small>Total</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection