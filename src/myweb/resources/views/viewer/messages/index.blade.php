<!-- resources/views/viewer/messages/index.blade.php -->
@extends('viewer.layouts.app')

@section('title', 'Messages')

@section('content')
<div class="content-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Messages</h4>
        <a href="{{ route('viewer.messages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Compose Message
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Inbox</h5>
        </div>
        <div class="card-body p-0">
            @if($messages->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="60"></th>
                                <th>Sender</th>
                                <th>Subject</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $message)
                                <tr class="{{ $message->is_read ? '' : 'table-active' }}">
                                    <td class="text-center">
                                        @if(!$message->is_read)
                                            <span class="badge bg-primary">New</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="fw-medium">{{ $message->sender->name }}</div>
                                                <small class="text-muted">{{ $message->sender->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ $message->subject }}</div>
                                        <small class="text-muted text-truncate d-block" style="max-width: 200px;">
                                            {{ Str::limit($message->message, 50) }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($message->type === 'application_update') bg-info
                                            @elseif($message->type === 'notification') bg-warning
                                            @else bg-secondary @endif">
                                            {{ Str::title(str_replace('_', ' ', $message->type)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $message->created_at->format('M j, Y') }}<br>
                                            {{ $message->created_at->format('g:i A') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('viewer.messages.show', $message) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(!$message->is_read)
                                                <form action="{{ route('viewer.messages.mark-read', $message) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="card-footer">
                    {{ $messages->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-envelope-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No messages found</h5>
                    <p class="text-muted">You don't have any messages yet.</p>
                    <a href="{{ route('viewer.messages.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Compose Your First Message
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.message-type-general { border-left: 4px solid var(--neutral-400); }
.message-type-application_update { border-left: 4px solid var(--info); }
.message-type-notification { border-left: 4px solid var(--warning); }

.table-active {
    background-color: var(--primary-50) !important;
    font-weight: 600;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateUnreadCount() {
        fetch('{{ route("viewer.messages.unread-count") }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.nav-link[href*="messages"] .badge');
                if (badge) {
                    if (data.unreadCount > 0) {
                        badge.textContent = data.unreadCount;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            });
    }
    
    setInterval(updateUnreadCount, 30000);
});
</script>
@endsection