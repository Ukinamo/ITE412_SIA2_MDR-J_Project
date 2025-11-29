<!-- resources/views/viewer/messages/create.blade.php -->
@extends('viewer.layouts.app')

@section('title', 'Compose Message')

@section('content')
<div class="content-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Compose Message</h4>
        <a href="{{ route('viewer.messages.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Inbox
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">New Message</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('viewer.messages.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="to_user_id" class="form-label">Recipient *</label>
                            <select class="form-select @error('to_user_id') is-invalid @enderror" 
                                    id="to_user_id" name="to_user_id" required>
                                <option value="">Select Recipient</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" 
                                            {{ old('to_user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }}) - {{ ucfirst($user->role) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('to_user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Reviewers can message Administrators and other Reviewers
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">Message Type *</label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
                                <option value="application_update" {{ old('type') == 'application_update' ? 'selected' : '' }}>Application Update</option>
                                <option value="notification" {{ old('type') == 'notification' ? 'selected' : '' }}>Notification</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subject *</label>
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                           id="subject" name="subject" value="{{ old('subject') }}" 
                           placeholder="Enter message subject" required>
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message *</label>
                    <textarea class="form-control @error('message') is-invalid @enderror" 
                              id="message" name="message" rows="8" 
                              placeholder="Type your message here..." required>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-text">
                        <i class="fas fa-info-circle me-1"></i>
                        All fields marked with * are required
                    </div>
                    <div>
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-redo me-1"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Send Message
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageTextarea = document.getElementById('message');
    const charCount = document.createElement('div');
    charCount.className = 'form-text text-end mt-1';
    charCount.innerHTML = '<span id="charCount">0</span> characters';
    messageTextarea.parentNode.appendChild(charCount);

    messageTextarea.addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length;
    });
});
</script>
@endsection