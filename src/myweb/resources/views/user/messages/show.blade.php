<!-- resources/views/user/messages/show.blade.php -->
@extends('user.layouts.app')

@section('title', 'View Message')

@section('content')
<div class="content-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">View Message</h4>
        <a href="{{ route('user.messages.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Inbox
        </a>
    </div>

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
            <!-- Message Header - Student Focused -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong class="text-muted">From Administrator:</strong>
                        <div class="d-flex align-items-center mt-2">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 48px; height: 48px;">
                                    <i class="fas fa-user-shield text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-medium text-dark">{{ $message->sender->name ?? 'Administrator' }}</div>
                                <small class="text-muted">Scholarship System Admin</small>
                                <div class="mt-1">
                                    <span class="badge bg-success">
                                        <i class="fas fa-shield-alt me-1"></i>Administrator
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <strong class="text-muted">Message Details:</strong>
                        <div class="mt-2">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-clock text-muted me-2"></i>
                                <small>{{ $message->created_at->format('F j, Y \a\t g:i A') }}</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle text-muted me-2"></i>
                                <small>
                                    @if($message->type === 'application_update')
                                        About your application
                                    @elseif($message->type === 'notification')
                                        Important announcement
                                    @else
                                        General communication
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
                <strong class="text-muted mb-2 d-block">Message Content:</strong>
                <div class="p-4 bg-light rounded border">
                    <div class="message-content" style="white-space: pre-wrap; line-height: 1.6; font-size: 0.95rem;">
                        {{ $message->message }}
                    </div>
                </div>
            </div>

            <!-- Application Context for Students -->
            @if($message->application)
            <div class="mb-4">
                <div class="alert alert-info">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-file-alt fa-2x text-info"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="alert-heading">Related to Your Application</h6>
                            <p class="mb-2">This message is regarding your scholarship application #{{ $message->application->id }}</p>
                            <a href="{{ route('applications.show', $message->application) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-external-link-alt me-1"></i>
                                View Application Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Help for Students -->
            <div class="mb-4">
                <div class="alert alert-warning">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-question-circle fa-2x text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="alert-heading">Need Help?</h6>
                            <p class="mb-1">If you have questions about this message or need clarification:</p>
                            <ul class="mb-2">
                                <li>Check your application status first</li>
                                <li>Review the scholarship requirements</li>
                                <li>Contact administrators for urgent matters</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @if(!$message->is_read)
                        <span class="badge bg-primary">
                            <i class="fas fa-envelope me-1"></i>New Message
                        </span>
                    @else
                        <small class="text-muted">
                            <i class="fas fa-check me-1"></i>
                            Read on {{ $message->updated_at->format('M j, Y') }}
                        </small>
                    @endif
                </div>
                <div class="btn-group">
                    <a href="{{ route('user.messages.create') }}?reply_to={{ $message->id }}" 
                       class="btn btn-primary">
                        <i class="fas fa-reply me-1"></i>Reply
                    </a>
                    <a href="{{ route('user.messages.create') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-envelope me-1"></i>New Message
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Support Information for Students -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-life-ring text-primary me-2"></i>
                        Student Support
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Office Hours:</strong> Mon-Fri, 9AM-5PM</p>
                    <p class="mb-2"><strong>Response Time:</strong> 1-2 business days</p>
                    <p class="mb-0"><strong>Urgent Matters:</strong> Use "Application Question" type</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-lightbulb text-warning me-2"></i>
                        Quick Tips
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Include your application ID in messages</li>
                        <li>Check spam folder if expecting reply</li>
                        <li>One question per message for faster response</li>
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

.alert {
    border-left: 4px solid;
}
</style>
@endsection