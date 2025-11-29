<!-- resources/views/user/applications/create.blade.php -->
@extends('user.layouts.app')

@section('title', 'Apply for ' . $program->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-paper-plane me-2"></i>Apply for {{ $program->name }}</h4>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Program Information</h6>
                    <p class="mb-1"><strong>Amount:</strong> ₱{{ number_format($program->amount, 2) }}</p>
                    <p class="mb-1"><strong>Deadline:</strong> {{ $program->deadline->format('F d, Y') }}</p>
                    <p class="mb-0"><strong>Requirements:</strong> 
                        @if($program->requirements)
                            {{ implode(', ', array_keys($program->requirements)) }}
                        @else
                            No specific requirements
                        @endif
                    </p>
                </div>

                <form method="POST" action="{{ route('applications.store', $program) }}" enctype="multipart/form-data" id="applicationForm">
                    @csrf

                    <!-- Scholarship Application Section - Certificate of Registration -->
                    <div class="mb-4">
                        <h5 class="text-primary border-bottom pb-2">Scholarship Application Documents</h5>
                        
                        <div class="mb-3">
                            <label for="cor_file" class="form-label">Certificate of Registration (COR) *</label>
                            <input type="file" class="form-control @error('cor_file') is-invalid @enderror" 
                                   id="cor_file" name="cor_file" accept=".pdf,.jpg,.jpeg,.png" required>
                            @error('cor_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Upload your Certificate of Registration as PDF, JPG, JPEG, or PNG file (max: 10MB)
                            </div>
                        </div>
                    </div>

                    <!-- Academic Records Section -->
                    <div class="mb-4">
                        <h5 class="text-primary border-bottom pb-2">Academic Records</h5>
                        
                        <div class="mb-3">
                            <label for="academic_records" class="form-label">Academic Background *</label>
                            <textarea class="form-control @error('academic_records') is-invalid @enderror" 
                                      id="academic_records" name="academic_records" rows="4" 
                                      placeholder="Please provide details about your academic background, GPA, courses taken, honors, etc." required>{{ old('academic_records') }}</textarea>
                            @error('academic_records')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Describe your academic achievements and records in detail.</div>
                        </div>

                        <div class="mb-3">
                            <label for="gwa_file" class="form-label">General Weighted Average (GWA) Proof *</label>
                            <input type="file" class="form-control @error('gwa_file') is-invalid @enderror" 
                                   id="gwa_file" name="gwa_file" accept=".pdf,.jpg,.jpeg,.png" required>
                            @error('gwa_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Upload screenshot or document showing your GWA as PDF, JPG, JPEG, or PNG file (max: 10MB)
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information Section -->
                    <div class="mb-4">
                        <h5 class="text-primary border-bottom pb-2">Financial Information</h5>
                        
                        <div class="mb-3">
                            <label for="financial_info" class="form-label">Financial Situation *</label>
                            <textarea class="form-control @error('financial_info') is-invalid @enderror" 
                                      id="financial_info" name="financial_info" rows="3" 
                                      placeholder="Describe your financial situation and need for this scholarship." required>{{ old('financial_info') }}</textarea>
                            @error('financial_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Explain why you need financial assistance for your education.</div>
                        </div>
                    </div>

                    <!-- Personal Essay Section -->
                    <div class="mb-4">
                        <h5 class="text-primary border-bottom pb-2">Personal Essay</h5>
                        
                        <div class="mb-3">
                            <label for="essay" class="form-label">Personal Statement *</label>
                            <textarea class="form-control @error('essay') is-invalid @enderror" 
                                      id="essay" name="essay" rows="6" 
                                      placeholder="Write a personal essay explaining your goals, achievements, and why you deserve this scholarship." required>{{ old('essay') }}</textarea>
                            @error('essay')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">This is your opportunity to showcase your personality and aspirations.</div>
                        </div>
                    </div>

                    <!-- Recommendation Information Section -->
                    <div class="mb-4">
                        <h5 class="text-primary border-bottom pb-2">Recommendation Information</h5>
                        
                        <div class="mb-3">
                            <label for="recommendation_letter" class="form-label">Recommendation Details (Optional)</label>
                            <textarea class="form-control @error('recommendation_letter') is-invalid @enderror" 
                                      id="recommendation_letter" name="recommendation_letter" rows="3" 
                                      placeholder="Provide information about your recommenders or attach recommendation details.">{{ old('recommendation_letter') }}</textarea>
                            @error('recommendation_letter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">List your recommenders and their contact information (optional).</div>
                        </div>

                        <div class="mb-3">
                            <label for="recommendation_file" class="form-label">Recommendation Letter Proof (Optional)</label>
                            <input type="file" class="form-control @error('recommendation_file') is-invalid @enderror" 
                                   id="recommendation_file" name="recommendation_file" accept=".pdf,.jpg,.jpeg,.png">
                            @error('recommendation_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Upload signed recommendation letter as PDF, JPG, JPEG, or PNG file (max: 10MB). Must include visible signature.
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Important:</strong> 
                        <ul class="mb-0 mt-2">
                            <li>Certificate of Registration (COR) and GWA proof are required</li>
                            <li>Recommendation letter is optional but recommended</li>
                            <li>All files must be in PDF, JPG, JPEG, or PNG format (max 10MB each)</li>
                            <li>Once submitted, you cannot edit your application</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                            <i class="fas fa-paper-plane me-2"></i>Submit Application
                        </button>
                        <a href="{{ route('programs.show', $program) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('applicationForm');
    const submitBtn = document.getElementById('submitBtn');
    const fileInputs = document.querySelectorAll('input[type="file"]');
    const maxSize = 10 * 1024 * 1024; // 10MB in bytes

    // File size validation
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.size > maxSize) {
                alert('File size must be less than 10MB');
                this.value = '';
            }
        });
    });

    // Form submission handler
    form.addEventListener('submit', function(e) {
        // Validate required files
        const corFile = document.getElementById('cor_file').files[0];
        const gwaFile = document.getElementById('gwa_file').files[0];

        if (!corFile) {
            e.preventDefault();
            alert('Please select a Certificate of Registration file.');
            return;
        }

        if (!gwaFile) {
            e.preventDefault();
            alert('Please select a GWA proof file.');
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
    });
});
</script>
@endsection