<!-- resources/views/viewer/messages/show.blade.php -->
@extends('viewer.layouts.app')

@section('title', 'View Message')

@section('content')
<div class="content-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">View Message</h4>
        <a href="{{ route('viewer.messages.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Inbox
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ $message->subject }}</h5>
                        <span class="badge 
                            @if($message->type === 'application_update') bg-info
                            @elseif($message->type === 'notification') bg-warning
                            @else bg-secondary @endif">
                            {{ Str::title(str_replace('_', ' ', $message->type)) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Message Header - Reviewer Focused -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong class="text-muted">From:</strong>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 48px; height: 48px;">
                                            @if($message->sender->role === 'admin')
                                                <i class="fas fa-user-shield text-primary"></i>
                                            @else
                                                <i class="fas fa-user-check text-info"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="fw-medium text-dark">{{ $message->sender->name ?? 'Unknown User' }}</div>
                                        <small class="text-muted">{{ $message->sender->email ?? 'N/A' }}</small>
                                        <div class="mt-1">
                                            <span class="badge 
                                                @if($message->sender->role === 'admin') bg-success
                                                @elseif($message->sender->role === 'viewer') bg-info
                                                @else bg-primary @endif">
                                                <i class="fas fa-{{ $message->sender->role === 'admin' ? 'shield-alt' : 'eye' }} me-1"></i>
                                                {{ ucfirst($message->sender->role ?? 'user') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong class="text-muted">Review Context:</strong>
                                <div class="mt-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar text-muted me-2"></i>
                                        <small>Sent: {{ $message->created_at->format('M j, Y g:i A') }}</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-tasks text-muted me-2"></i>
                                        <small>
                                            @if($message->type === 'application_update')
                                                Review-related update
                                            @elseif($message->type === 'notification')
                                                System notification
                                            @else
                                                Team communication
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Message Content -->
                    <div class="mb-4">
                        <strong class="text-muted mb-2 d-block">Message:</strong>
                        <div class="p-4 bg-light rounded border">
                            <div class="message-content" style="white-space: pre-wrap; line-height: 1.6;">
                                {{ $message->message }}
                            </div>
                        </div>
                    </div>

                    <!-- Application Context for Reviewers -->
                    @if($message->application)
                    <div class="mb-4">
                        <strong class="text-muted mb-2 d-block">Related Application:</strong>
                        <div class="p-3 bg-info bg-opacity-10 rounded border">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Application #{{ $message->application->id }}</h6>
                                    <p class="text-muted mb-0">
                                        Program: {{ $message->application->program->name ?? 'N/A' }}
                                    </p>
                                    <small class="text-muted">
                                        Current Status: 
                                        <span class="badge 
                                            @if($message->application->status === 'approved') bg-success
                                            @elseif($message->application->status === 'rejected') bg-danger
                                            @elseif($message->application->status === 'under_review') bg-warning
                                            @else bg-secondary @endif">
                                            {{ Str::title(str_replace('_', ' ', $message->application->status)) }}
                                        </span>
                                    </small>
                                </div>
                                <a href="{{ route('viewer.applications.show', $message->application) }}" 
                                   class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-external-link-alt me-1"></i>
                                    Review Application
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if(!$message->is_read)
                                <span class="badge bg-primary">
                                    <i class="fas fa-envelope me-1"></i>Unread
                                </span>
                            @else
                                <small class="text-muted">
                                    <i class="fas fa-check me-1"></i>
                                    Read {{ $message->updated_at->diffForHumans() }}
                                </small>
                            @endif
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('viewer.messages.create') }}?reply_to={{ $message->id }}" 
                               class="btn btn-primary">
                                <i class="fas fa-reply me-1"></i>Reply
                            </a>
                            <a href="{{ route('viewer.messages.create') }}?forward={{ $message->id }}" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-share me-1"></i>Forward
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - Reviewer Tools -->
        <div class="col-lg-4">
            <!-- Review Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-tasks text-primary me-2"></i>
                        Review Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('viewer.messages.create') }}?reply_to={{ $message->id }}" 
                           class="btn btn-primary">
                            <i class="fas fa-reply me-2"></i>Reply
                        </a>
                        @if($message->application)
                            <a href="{{ route('viewer.applications.show', $message->application) }}" 
                               class="btn btn-outline-info">
                                <i class="fas fa-file-alt me-2"></i>View Application
                            </a>
                        @endif
                        @if(!$message->is_read)
                            <form action="{{ route('viewer.messages.mark-read', $message) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="fas fa-check me-2"></i>Mark as Read
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Message Context -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        Review Context
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Message Type</small>
                        <div class="fw-medium">
                            <span class="badge 
                                @if($message->type === 'application_update') bg-info
                                @elseif($message->type === 'notification') bg-warning
                                @else bg-secondary @endif">
                                {{ Str::title(str_replace('_', ' ', $message->type)) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block">Priority Level</small>
                        <div class="fw-medium">
                            @if($message->type === 'application_update')
                                <span class="badge bg-warning">Review Priority</span>
                            @elseif($message->type === 'notification')
                                <span class="badge bg-danger">High Priority</span>
                            @else
                                <span class="badge bg-secondary">Normal</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Sender Role</small>
                        <div class="fw-medium">
                            <span class="badge 
                                @if($message->sender->role === 'admin') bg-success
                                @elseif($message->sender->role === 'viewer') bg-info
                                @else bg-primary @endif">
                                {{ ucfirst($message->sender->role ?? 'user') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Guidelines -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-clipboard-check text-success me-2"></i>
                        Review Guidelines
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li>Respond to admin messages within 24 hours</li>
                        <li>Coordinate with other reviewers when needed</li>
                        <li>Use application context in replies</li>
                        <li>Maintain professional communication</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.message-content {
    font-size: 0.95rem;
    line-height: 1.6;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
</style>
@endsection