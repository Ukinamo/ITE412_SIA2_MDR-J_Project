<!-- resources/views/admin/applications/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'All Applications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-list me-2"></i>All Scholarship Applications</h4>
    <div class="btn-group">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>
</div>

<div class="card border-danger">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">Application Management</h5>
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
                        <th>Assigned Reviewer</th>
                        <th>Evaluations</th>
                        <th>Applied Date</th>
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
                            @if($application->assignee)
                                {{ $application->assignee->name }}
                            @else
                                <span class="text-muted">Not assigned</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $application->evaluations->count() }}</span>
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

        @if($applications->count() === 0)
        <div class="text-center py-5">
            <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">No applications found.</h5>
        </div>
        @endif
    </div>
</div>
@endsection