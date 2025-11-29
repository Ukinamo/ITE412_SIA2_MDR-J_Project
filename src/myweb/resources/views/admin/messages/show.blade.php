<!-- resources/views/admin/messages/show.blade.php -->
@extends('admin.layouts.app')

@section('title', 'View Message')

@section('content')
<div class="content-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">View Message</h4>
        <div>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Back to Inbox
            </a>
            <a href="{{ route('admin.messages.create') }}?reply_to={{ $message->id }}" 
               class="btn btn-primary">
                <i class="fas fa-reply me-2"></i>Reply
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">{{ $message->subject }}</h5>
                        <div>
                            <span class="badge 
                                @if($message->type === 'application_update') bg-info
                                @elseif($message->type === 'notification') bg-warning
                                @else bg-secondary @endif">
                                {{ Str::title(str_replace('_', ' ', $message->type)) }}
                            </span>
                            @if(!$message->is_read)
                                <span class="badge bg-danger ms-2">Unread</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Message Header - Administrative Focus -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong class="text-muted">Communication Details:</strong>
                                <div class="mt-2">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 48px; height: 48px;">
                                                <i class="fas fa-user text-primary"></i>
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
                                                    {{ ucfirst($message->sender->role ?? 'user') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong class="text-muted">Recipient Information:</strong>
                                <div class="mt-2">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 48px; height: 48px;">
                                                <i class="fas fa-user text-success"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fw-medium text-dark">{{ $message->recipient->name ?? 'Unknown User' }}</div>
                                            <small class="text-muted">{{ $message->recipient->email ?? 'N/A' }}</small>
                                            <div class="mt-1">
                                                <span class="badge 
                                                    @if($message->recipient->role === 'admin') bg-success
                                                    @elseif($message->recipient->role === 'viewer') bg-info
                                                    @else bg-primary @endif">
                                                    {{ ucfirst($message->recipient->role ?? 'user') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Administrative Status -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock text-muted me-2"></i>
                                <div>
                                    <small class="text-muted">Sent</small>
                                    <div class="fw-medium">{{ $message->created_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-eye text-muted me-2"></i>
                                <div>
                                    <small class="text-muted">Status</small>
                                    <div>
                                        @if($message->is_read)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Read
                                            </span>
                                            <small class="text-muted ms-2">
                                                {{ $message->updated_at->format('M j, Y g:i A') }}
                                            </small>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Unread
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Message Content -->
                    <div class="mb-4">
                        <strong class="text-muted mb-2 d-block">Message Content:</strong>
                        <div class="p-4 bg-light rounded border">
                            <div class="message-content" style="white-space: pre-wrap; line-height: 1.6;">
                                {{ $message->message }}
                            </div>
                        </div>
                    </div>

                    <!-- Related Application -->
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
                                    <br>
                                    <small class="text-muted">
                                        Applicant: {{ $message->application->user->name ?? 'Unknown' }}
                                    </small>
                                </div>
                                @if(Route::has('admin.applications.show'))
                                <a href="{{ route('admin.applications.show', $message->application) }}" 
                                   class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-external-link-alt me-1"></i>
                                    Manage Application
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Message ID: #{{ $message->id }}
                            </small>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('admin.messages.create') }}?reply_to={{ $message->id }}" 
                               class="btn btn-primary">
                                <i class="fas fa-reply me-1"></i>Reply
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - Administrative Tools -->
        <div class="col-lg-4">
            <!-- Administrative Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cogs text-primary me-2"></i>
                        Administrative Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.messages.create') }}?reply_to={{ $message->id }}" 
                           class="btn btn-primary">
                            <i class="fas fa-reply me-2"></i>Reply to Message
                        </a>
                        @if(!$message->is_read)
                            <form action="{{ route('admin.messages.mark-read', $message) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="fas fa-check me-2"></i>Mark as Read
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Message Analytics -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar text-info me-2"></i>
                        Message Analytics
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
                        <small class="text-muted d-block">Administrative Priority</small>
                        <div class="fw-medium">
                            @if($message->type === 'application_update')
                                <span class="badge bg-warning">Medium Priority</span>
                            @elseif($message->type === 'notification')
                                <span class="badge bg-danger">High Priority</span>
                            @else
                                <span class="badge bg-secondary">Normal Priority</span>
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

                    <div class="mb-3">
                        <small class="text-muted d-block">Response Time</small>
                        <div class="fw-medium">
                            @if($message->is_read)
                                @php
                                    $responseTime = $message->created_at->diffInHours($message->updated_at);
                                @endphp
                                @if($responseTime < 1)
                                    <span class="badge bg-success">Within 1 hour</span>
                                @elseif($responseTime < 24)
                                    <span class="badge bg-info">{{ $responseTime }} hours</span>
                                @else
                                    <span class="badge bg-warning">{{ ceil($responseTime / 24) }} days</span>
                                @endif
                            @else
                                <span class="badge bg-secondary">Pending response</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Management -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-users-cog text-success me-2"></i>
                        User Management
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 64px; height: 64px;">
                            <i class="fas fa-user fa-lg text-primary"></i>
                        </div>
                    </div>
                    
                    <div class="text-center mb-3">
                        <h6 class="mb-1">{{ $message->sender->name ?? 'Unknown User' }}</h6>
                        <p class="text-muted mb-2">{{ $message->sender->email ?? 'N/A' }}</p>
                        <span class="badge 
                            @if($message->sender->role === 'admin') bg-success
                            @elseif($message->sender->role === 'viewer') bg-info
                            @else bg-primary @endif">
                            {{ ucfirst($message->sender->role ?? 'user') }}
                        </span>
                    </div>

                    <div class="d-grid gap-2">
                        <!-- Safe links with route existence checks -->
                        @if($message->sender->role === 'user')
                            @if(Route::has('admin.users.show'))
                            <a href="{{ route('admin.users.show', $message->sender) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View Student Profile
                            </a>
                            @endif
                            @if(Route::has('admin.applications.index'))
                            <a href="{{ route('admin.applications.index') }}?user={{ $message->sender->id }}" 
                               class="btn btn-outline-info btn-sm">
                                <i class="fas fa-file-alt me-1"></i>View Applications
                            </a>
                            @endif
                        @elseif($message->sender->role === 'viewer')
                            @if(Route::has('admin.users.show'))
                            <a href="{{ route('admin.users.show', $message->sender) }}" 
                               class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye me-1"></i>View Reviewer Profile
                            </a>
                            @endif
                            @if(Route::has('admin.applications.index'))
                            <a href="{{ route('admin.applications.index') }}?reviewer={{ $message->sender->id }}" 
                               class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-tasks me-1"></i>Assigned Reviews
                            </a>
                            @endif
                        @endif
                        
                        <a href="{{ route('admin.messages.create') }}?to_user_id={{ $message->sender->id }}" 
                           class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-envelope me-1"></i>Send New Message
                        </a>
                    </div>
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

.card-header {
    background-color: rgba(0, 0, 0, 0.03);
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.badge {
    font-size: 0.75em;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus reply button for keyboard navigation
    const replyBtn = document.querySelector('a[href*="reply_to"]');
    if (replyBtn) {
        replyBtn.focus();
    }

    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + R for reply
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            if (replyBtn) {
                replyBtn.click();
            }
        }
        
        // Ctrl + Back to inbox
        if (e.ctrlKey && e.key === 'b') {
            e.preventDefault();
            const backBtn = document.querySelector('a[href*="messages.index"]');
            if (backBtn) {
                backBtn.click();
            }
        }
    });
});
</script>
@endsection