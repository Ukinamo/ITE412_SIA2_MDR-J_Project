<!-- resources/views/admin/dashboard/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-2 mb-4">
        <div class="card text-white bg-danger">
            <div class="card-body text-center">
                <h2 class="card-title">{{ $totalApplications }}</h2>
                <p class="card-text">Total Applications</p>
                <i class="fas fa-file-alt fa-2x"></i>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h2 class="card-title">{{ $pendingApplications }}</h2>
                <p class="card-text">Pending Review</p>
                <i class="fas fa-clock fa-2x"></i>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h2 class="card-title">{{ $underReviewApplications }}</h2>
                <p class="card-text">Under Review</p>
                <i class="fas fa-search fa-2x"></i>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h2 class="card-title">{{ $activePrograms }}</h2>
                <p class="card-text">Active Programs</p>
                <i class="fas fa-graduation-cap fa-2x"></i>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h2 class="card-title">{{ $totalStudents }}</h2>
                <p class="card-text">Students</p>
                <i class="fas fa-users fa-2x"></i>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-4">
        <div class="card text-white bg-secondary">
            <div class="card-body text-center">
                <h2 class="card-title">{{ $totalReviewers }}</h2>
                <p class="card-text">Reviewers</p>
                <i class="fas fa-user-check fa-2x"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Recent Applications</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Program</th>
                                <th>Status</th>
                                <th>Assigned To</th>
                                <th>Applied Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentApplications as $application)
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
                                <td>
                                    @if($application->assignee)
                                        {{ $application->assignee->name }}
                                    @else
                                        <span class="text-muted">Not assigned</span>
                                    @endif
                                </td>
                                <td>{{ $application->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('applications.show', $application) }}" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.applications.index') }}" class="btn btn-danger">
                        <i class="fas fa-list me-2"></i>View All Applications
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Program Statistics</h5>
            </div>
            <div class="card-body">
                @foreach($programs as $program)
                <div class="mb-3 p-3 border rounded">
                    <h6 class="mb-1">{{ $program->name }}</h6>
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Applications: {{ $program->applications_count }}</span>
                        <span>Active: {{ $program->active_applications_count }}</span>
                    </div>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ $program->applications_count > 0 ? min(($program->active_applications_count / $program->applications_count) * 100, 100) : 0 }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small>Amount: ₱{{ number_format($program->amount) }}</small>
                        <small>Deadline: {{ $program->deadline->format('M d') }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-rocket me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.programs.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus-circle me-2"></i>Create New Program
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-danger">
                        <i class="fas fa-users me-2"></i>Manage Users
                    </a>
                    <a href="{{ route('admin.messages.create') }}" class="btn btn-outline-danger">
                        <i class="fas fa-envelope me-2"></i>Send Message
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection