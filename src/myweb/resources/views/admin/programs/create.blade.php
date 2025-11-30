<!-- resources/views/admin/programs/create.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Create Scholarship Program')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card" style="border-color: #4CAF50;">
            <div class="card-header text-white" style="background-color: #4CAF50;">
                <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Create New Scholarship Program</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.programs.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Program Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Scholarship Amount (₱) *</label>
                            <input type="number" step="0.01" min="0" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount') }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="deadline" class="form-label">Application Deadline *</label>
                            <input type="date" class="form-control @error('deadline') is-invalid @enderror" 
                                   id="deadline" name="deadline" value="{{ old('deadline') }}" 
                                   min="{{ date('Y-m-d') }}" required>
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Requirements</label>
                        <div class="alert text-white" style="background-color: #81C784;">
                            <small><i class="fas fa-info-circle me-1"></i> Add key-value pairs for program requirements (e.g., "Minimum GPA": "3.5 or higher")</small>
                        </div>
                        <div id="requirements-container">
                            @if(old('requirements'))
                                @php
                                    $oldRequirements = is_array(old('requirements')) ? old('requirements') : [];
                                @endphp
                                @foreach($oldRequirements as $index => $requirement)
                                    @if(isset($requirement['key']) && isset($requirement['value']))
                                    <div class="requirement-item row mb-2">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="requirements[{{ $index }}][key]" 
                                                   placeholder="Requirement name" value="{{ $requirement['key'] }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="requirements[{{ $index }}][value]" 
                                                   placeholder="Requirement details" value="{{ $requirement['value'] }}" required>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn text-white remove-requirement" style="background-color: #D32F2F; border-color: #D32F2F;" {{ $loop->first ? 'disabled' : '' }}>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            @else
                            <div class="requirement-item row mb-2">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="requirements[0][key]" 
                                           placeholder="e.g., Minimum GPA" value="{{ old('requirements.0.key', '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="requirements[0][value]" 
                                           placeholder="e.g., 3.5 or higher" value="{{ old('requirements.0.value', '') }}" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn text-white remove-requirement" style="background-color: #D32F2F; border-color: #D32F2F;" disabled>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                        <button type="button" id="add-requirement" class="btn text-white btn-sm mt-2" style="background-color: #43A047; border-color: #43A047;">
                            <i class="fas fa-plus me-1"></i>Add Requirement
                        </button>
                        @error('requirements')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        @error('requirements.*')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Activate program immediately</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn text-white btn-lg" style="background-color: #4CAF50; border-color: #4CAF50;">
                            <i class="fas fa-save me-2"></i>Create Scholarship Program
                        </button>
                        <a href="{{ route('programs.index') }}" class="btn" style="background-color: #EEEEEE; border-color: #BDBDBD;">
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
    let requirementCount = document.querySelectorAll('.requirement-item').length;
    
    document.getElementById('add-requirement').addEventListener('click', function() {
        const container = document.getElementById('requirements-container');
        const newItem = document.createElement('div');
        newItem.className = 'requirement-item row mb-2';
        newItem.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control" name="requirements[${requirementCount}][key]" 
                       placeholder="Requirement name" required>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" name="requirements[${requirementCount}][value]" 
                       placeholder="Requirement details" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn text-white remove-requirement" style="background-color: #D32F2F; border-color: #D32F2F;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        container.appendChild(newItem);
        requirementCount++;
        
        // Enable all remove buttons except the first one
        updateRemoveButtons();
    });

    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-requirement');
        removeButtons.forEach((button, index) => {
            button.disabled = index === 0;
        });
    }

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-requirement') && !e.target.closest('.remove-requirement').disabled) {
            e.target.closest('.requirement-item').remove();
            requirementCount--;
            
            // Re-index the remaining requirements
            const container = document.getElementById('requirements-container');
            const items = container.querySelectorAll('.requirement-item');
            items.forEach((item, index) => {
                const keyInput = item.querySelector('input[name*="[key]"]');
                const valueInput = item.querySelector('input[name*="[value]"]');
                
                keyInput.name = `requirements[${index}][key]`;
                valueInput.name = `requirements[${index}][value]`;
            });
            
            updateRemoveButtons();
        }
    });

    // Set minimum date for deadline to today
    const deadlineInput = document.getElementById('deadline');
    if (!deadlineInput.value) {
        const today = new Date().toISOString().split('T')[0];
        deadlineInput.value = today;
    }

    // Initialize remove buttons state
    updateRemoveButtons();
});
</script>

<style>
.remove-requirement:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
@endsection