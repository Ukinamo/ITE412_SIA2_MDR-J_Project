<!-- resources/views/user/dashboard/index.blade.php -->
@extends('user.layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $pendingApplications }}</h4>
                        <p class="card-text">Pending Applications</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $approvedApplications }}</h4>
                        <p class="card-text">Approved Applications</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $unreadMessages }}</h4>
                        <p class="card-text">Unread Messages</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-envelope fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $activePrograms->count() }}</h4>
                        <p class="card-text">Available Programs</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-graduation-cap fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Recent Applications</h5>
            </div>
            <div class="card-body">
                @if($applications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Program</th>
                                    <th>Status</th>
                                    <th>Applied Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                <tr>
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
                                    <td>{{ $application->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('applications.show', $application) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted">You haven't submitted any applications yet.</p>
                        <a href="{{ route('programs.index') }}" class="btn btn-primary">
                            <i class="fas fa-graduation-cap me-2"></i>Browse Scholarship Programs
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Available Programs</h5>
            </div>
            <div class="card-body">
                @if($activePrograms->count() > 0)
                    @foreach($activePrograms as $program)
                    <div class="mb-3 p-3 border rounded">
                        <h6 class="mb-1">{{ $program->name }}</h6>
                        <p class="text-muted small mb-2">{{ Str::limit($program->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success">${{ number_format($program->amount) }}</span>
                            <small class="text-muted">Deadline: {{ $program->deadline->format('M d, Y') }}</small>
                        </div>
                        <a href="{{ route('applications.create', $program) }}" class="btn btn-sm btn-primary mt-2 w-100">
                            Apply Now
                        </a>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No available programs at the moment.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection