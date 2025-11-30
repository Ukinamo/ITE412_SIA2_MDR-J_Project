<!-- resources/views/viewer/applications/show.blade.php -->
@extends('viewer.layouts.app')

@section('title', 'Application Review')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-file-alt me-2"></i>Application Review</h4>
    <a href="{{ route('viewer.applications.index') }}" class="btn btn-outline-warning">
        <i class="fas fa-arrow-left me-2"></i>Back to Assigned Applications
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Application Review - {{ $application->program->name }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>Student:</strong> {{ $application->user->name }}<br>
                        <strong>Email:</strong> {{ $application->user->email }}<br>
                        <strong>Program:</strong> {{ $application->program->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <span class="badge 
                            @if($application->status == 'approved') bg-success
                            @elseif($application->status == 'rejected') bg-danger
                            @elseif($application->status == 'under_review') bg-warning
                            @else bg-secondary @endif">
                            {{ ucfirst($application->status) }}
                        </span><br>
                        <strong>Amount:</strong> ₱{{ number_format($application->program->amount) }}<br>
                        <strong>Submitted:</strong>
                        {{ $application->submitted_at ? $application->submitted_at->format('M d, Y') : $application->created_at->format('M d, Y') }}
                    </div>
                </div>

                <!-- Uploaded Files Section - FIXED -->
                <div class="mb-4">
                    <h6 class="text-warning">Uploaded Documents</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card border-success h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-certificate fa-2x text-success mb-2"></i>
                                    <h6>Certificate of Registration</h6>
                                    @if($application->cor_file_path)
                                        <a href="{{ route('applications.download', ['application' => $application, 'fileType' => 'cor']) }}" 
                                           class="btn btn-sm btn-success mt-2" target="_blank">
                                            <i class="fas fa-download me-1"></i>Download COR
                                        </a>
                                        <small class="d-block text-muted mt-1">Required Document</small>
                                    @else
                                        <span class="badge bg-danger mt-2">Not Uploaded</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-info h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                                    <h6>GWA Proof</h6>
                                    @if($application->gwa_file_path)
                                        <a href="{{ route('applications.download', ['application' => $application, 'fileType' => 'gwa']) }}" 
                                           class="btn btn-sm btn-info mt-2" target="_blank">
                                            <i class="fas fa-download me-1"></i>Download GWA
                                        </a>
                                        <small class="d-block text-muted mt-1">Required Document</small>
                                    @else
                                        <span class="badge bg-danger mt-2">Not Uploaded</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-warning h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-envelope-open-text fa-2x text-warning mb-2"></i>
                                    <h6>Recommendation Letter</h6>
                                    @if($application->recommendation_file_path)
                                        <a href="{{ route('applications.download', ['application' => $application, 'fileType' => 'recommendation']) }}" 
                                           class="btn btn-sm btn-warning mt-2" target="_blank">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                        <small class="d-block text-muted mt-1">Optional Document</small>
                                    @else
                                        <span class="badge bg-secondary mt-2">Not Provided</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="application-data">
                    <h6>Academic Records:</h6>
                    <div class="border p-3 rounded bg-light mb-3">
                        {{ $application->application_data['academic_records'] ?? 'N/A' }}
                    </div>

                    <h6>Financial Information:</h6>
                    <div class="border p-3 rounded bg-light mb-3">
                        {{ $application->application_data['financial_info'] ?? 'N/A' }}
                    </div>

                    <h6>Personal Essay:</h6>
                    <div class="border p-3 rounded bg-light mb-3">
                        {{ $application->application_data['essay'] ?? 'N/A' }}
                    </div>

                    @if($application->application_data['recommendation_letter'] ?? false)
                    <h6>Recommendation Information:</h6>
                    <div class="border p-3 rounded bg-light">
                        {{ $application->application_data['recommendation_letter'] }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Existing Evaluations Section -->
        @if($application->evaluations->count() > 0)
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-star me-2"></i>Previous Evaluations</h6>
            </div>
            <div class="card-body">
                @foreach($application->evaluations as $evaluation)
                <div class="evaluation-item border-bottom pb-3 mb-3">
                    <strong>Reviewer:</strong> {{ $evaluation->reviewer->name }}<br>
                    <strong>Score:</strong> {{ $evaluation->score }}/100<br>
                    <strong>Recommendation:</strong>
                    <span class="badge 
                        @if($evaluation->recommendation == 'approve') bg-success
                        @elseif($evaluation->recommendation == 'reject') bg-danger
                        @else bg-warning @endif">
                        {{ ucfirst($evaluation->recommendation) }}
                    </span><br>
                    <strong>Comments:</strong>
                    <p class="mt-2">{{ $evaluation->comments }}</p>
                    <small class="text-muted">
                        Evaluated: {{ $evaluation->created_at->format('M d, Y') }}
                    </small>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Evaluation Action -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="fas fa-star me-2"></i>Submit Evaluation</h6>
            </div>
            <div class="card-body">
                @php
                    $userEvaluation = $application->evaluations->where('reviewer_id', Auth::id())->first();
                @endphp
                
                @if(!$userEvaluation)
                    <a href="{{ route('evaluations.create', $application) }}" class="btn btn-warning w-100">
                        <i class="fas fa-edit me-2"></i>Evaluate Application
                    </a>
                @else
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        You have already evaluated this application.
                    </div>
                    <a href="{{ route('evaluations.create', $application) }}" class="btn btn-outline-warning w-100">
                        <i class="fas fa-edit me-2"></i>Update Evaluation
                    </a>
                @endif
            </div>
        </div>

        <!-- Application Info -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Review Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Application Status:</strong>
                    <span class="badge 
                        @if($application->status == 'approved') bg-success
                        @elseif($application->status == 'rejected') bg-danger
                        @elseif($application->status == 'under_review') bg-warning
                        @else bg-secondary @endif">
                        {{ ucfirst($application->status) }}
                    </span>
                </div>
                
                @if($application->admin_notes)
                <div class="mb-3">
                    <strong>Admin Notes:</strong>
                    <p class="mt-1">{{ $application->admin_notes }}</p>
                </div>
                @endif

                <div class="text-muted small">
                    <i class="fas fa-clock me-1"></i>
                    Assigned: {{ $application->updated_at->format('M d, Y H:i') }}
                </div>
            </div>
        </div>

        <!-- Messages Section -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-comments me-2"></i>Messages</h6>
            </div>
            <div class="card-body">
                @if($application->messages->count() > 0)
                    @foreach($application->messages as $message)
                    <div class="message-item border-bottom pb-2 mb-2">
                        <strong>{{ $message->sender->name }}</strong>
                        <small class="text-muted">
                            ({{ $message->created_at->format('M d, Y H:i') }})
                        </small>
                        @if($message->subject)
                            <div><strong>Subject:</strong> {{ $message->subject }}</div>
                        @endif
                        <p class="mb-1">{{ $message->message }}</p>
                        <span class="badge bg-secondary">{{ $message->type }}</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted">No messages yet.</p>
                @endif

                <!-- Send Message Form (to Admin) -->
                <form method="POST" action="{{ route('viewer.messages.store') }}" class="mt-3">
                    @csrf
                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                    @php
                        $admin = \App\Models\User::where('role', 'admin')->first();
                    @endphp
                    <input type="hidden" name="to_user_id" value="{{ $admin->id ?? '' }}">
                    <input type="hidden" name="type" value="application_update">
                    <div class="mb-2">
                        <label class="form-label"><small>Message to Admin</small></label>
                        <input type="text" name="subject" class="form-control form-control-sm" placeholder="Subject" required>
                        <textarea name="message" class="form-control form-control-sm mt-1" rows="2" placeholder="Your message..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-warning w-100">Send to Admin</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection