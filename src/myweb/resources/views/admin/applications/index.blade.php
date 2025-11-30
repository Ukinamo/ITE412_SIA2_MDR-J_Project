<!-- resources/views/admin/applications/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'All Applications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-list me-2"></i>All Scholarship Applications</h4>
    <div class="btn-group">
        <a href="{{ route('admin.dashboard') }}" class="btn text-white" style="background-color: #4CAF50; border-color: #4CAF50;">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>
</div>

<div class="card" style="border-color: #4CAF50;">
    <div class="card-header text-white" style="background-color: #4CAF50;">
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
                        <td>₱{{ number_format($application->program->amount, 2) }}</td>
                        <td>
                            <span class="badge text-white
                                @if($application->status == 'approved')" style="background-color: #2E7D32;"
                                @elseif($application->status == 'rejected')" style="background-color: #D32F2F;"
                                @elseif($application->status == 'under_review')" style="background-color: #FBC02D;"
                                @else" style="background-color: #616161;" @endif>
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
                            <span class="badge text-white" style="background-color: #43A047;">{{ $application->evaluations->count() }}</span>
                        </td>
                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('applications.show', $application) }}" class="btn btn-sm text-white" style="background-color: #4CAF50; border-color: #4CAF50;">
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