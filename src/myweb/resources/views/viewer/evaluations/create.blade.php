<!-- resources/views/viewer/evaluations/create.blade.php -->
@extends('viewer.layouts.app')

@section('title', 'Evaluate Application')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="fas fa-star me-2"></i>Evaluate Application</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Application Information</h6>
                    <p class="mb-1"><strong>Student:</strong> {{ $application->user->name }}</p>
                    <p class="mb-1"><strong>Program:</strong> {{ $application->program->name }}</p>
                    <p class="mb-0"><strong>Amount:</strong> ${{ number_format($application->program->amount, 2) }}</p>
                </div>

                <form method="POST" action="{{ route('evaluations.store', $application) }}">
                    @csrf

                    <div class="mb-4">
                        <h5>Evaluation Criteria</h5>
                        
                        <div class="mb-3">
                            <label for="academic_score" class="form-label">Academic Merit (0-25 points)</label>
                            <input type="range" class="form-range" id="academic_score" name="criteria_scores[academic]" 
                                   min="0" max="25" value="0" oninput="academicValue.value = this.value">
                            <div class="d-flex justify-content-between">
                                <small>0 - Poor</small>
                                <output id="academicValue">0</output>
                                <small>25 - Excellent</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="financial_score" class="form-label">Financial Need (0-25 points)</label>
                            <input type="range" class="form-range" id="financial_score" name="criteria_scores[financial]" 
                                   min="0" max="25" value="0" oninput="financialValue.value = this.value">
                            <div class="d-flex justify-content-between">
                                <small>0 - No Need</small>
                                <output id="financialValue">0</output>
                                <small>25 - High Need</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="essay_score" class="form-label">Essay Quality (0-25 points)</label>
                            <input type="range" class="form-range" id="essay_score" name="criteria_scores[essay]" 
                                   min="0" max="25" value="0" oninput="essayValue.value = this.value">
                            <div class="d-flex justify-content-between">
                                <small>0 - Poor</small>
                                <output id="essayValue">0</output>
                                <small>25 - Excellent</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="overall_score" class="form-label">Overall Impression (0-25 points)</label>
                            <input type="range" class="form-range" id="overall_score" name="criteria_scores[overall]" 
                                   min="0" max="25" value="0" oninput="overallValue.value = this.value">
                            <div class="d-flex justify-content-between">
                                <small>0 - Poor</small>
                                <output id="overallValue">0</output>
                                <small>25 - Excellent</small>
                            </div>
                        </div>

                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h4>Total Score: <span id="totalScore">0</span>/100</h4>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="score" class="form-label">Final Score (0-100) *</label>
                        <input type="number" class="form-control @error('score') is-invalid @enderror" 
                               id="score" name="score" min="0" max="100" value="0" required readonly>
                        @error('score')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="recommendation" class="form-label">Recommendation *</label>
                        <select class="form-select @error('recommendation') is-invalid @enderror" 
                                id="recommendation" name="recommendation" required>
                            <option value="">Select Recommendation</option>
                            <option value="approve">Approve</option>
                            <option value="reject">Reject</option>
                            <option value="waitlist">Waitlist</option>
                        </select>
                        @error('recommendation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="comments" class="form-label">Evaluation Comments *</label>
                        <textarea class="form-control @error('comments') is-invalid @enderror" 
                                  id="comments" name="comments" rows="5" 
                                  placeholder="Provide detailed comments about the application, strengths, weaknesses, and reasons for your recommendation." required>{{ old('comments') }}</textarea>
                        @error('comments')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Important:</strong> Once submitted, this evaluation cannot be edited. Please review all scores and comments carefully.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="fas fa-star me-2"></i>Submit Evaluation
                        </button>
                        <a href="{{ route('applications.show', $application) }}" class="btn btn-outline-secondary">
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
    const sliders = document.querySelectorAll('input[type="range"]');
    const scoreInput = document.getElementById('score');
    const totalScoreSpan = document.getElementById('totalScore');

    function updateTotalScore() {
        let total = 0;
        sliders.forEach(slider => {
            total += parseInt(slider.value);
        });
        scoreInput.value = total;
        totalScoreSpan.textContent = total;
    }

    sliders.forEach(slider => {
        slider.addEventListener('input', updateTotalScore);
    });

    // Initial calculation
    updateTotalScore();
});
</script>
@endsection