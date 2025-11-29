<!-- resources/views/user/applications/index.blade.php -->
@extends('user.layouts.app')

@section('title', 'My Applications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-file-alt me-2"></i>My Scholarship Applications</h4>
    <a href="{{ route('programs.index') }}" class="btn btn-primary">
        <i class="fas fa-graduation-cap me-2"></i>Browse Programs
    </a>
</div>

@if($applications->count() > 0)
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Application History</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Assigned Reviewer</th>
                        <th>Applied Date</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                    <tr>
                        <td>
                            <strong>{{ $application->program->name }}</strong>
                            <br>
                            <small class="text-muted">{{ Str::limit($application->program->description, 50) }}</small>
                        </td>
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
                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                        <td>{{ $application->updated_at->format('M d, Y') }}</td>
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
    </div>
</div>
@else
<div class="text-center py-5">
    <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
    <h5 class="text-muted">You haven't submitted any applications yet.</h5>
    <p class="text-muted mb-4">Browse available scholarship programs and apply today!</p>
    <a href="{{ route('programs.index') }}" class="btn btn-primary btn-lg">
        <i class="fas fa-graduation-cap me-2"></i>Browse Scholarship Programs
    </a>
</div>
@endif
@endsection