<!-- resources/views/viewer/programs/index.blade.php -->
@extends('viewer.layouts.app')

@section('title', 'Scholarship Programs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-graduation-cap me-2"></i>Scholarship Programs</h4>
</div>

<div class="row">
    @foreach($programs as $program)
    <div class="col-md-6 mb-4">
        <div class="card card-viewer h-100">
            <div class="card-header card-header-viewer">
                <h5 class="mb-0">{{ $program->name }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $program->description }}</p>
                
                <div class="mb-3">
                    <strong>Amount:</strong> 
                    <span class="badge bg-success">${{ number_format($program->amount, 2) }}</span>
                </div>
                
                <div class="mb-3">
                    <strong>Deadline:</strong> 
                    <span class="badge 
                        @if($program->deadline->isPast()) bg-danger
                        @elseif($program->deadline->diffInDays(now()) < 7) bg-warning
                        @else bg-secondary @endif">
                        {{ $program->deadline->format('F d, Y') }}
                    </span>
                </div>

                @php
                    $requirements = $program->requirements;
                @endphp

                @if(!empty($requirements) && is_array($requirements))
                <div class="mb-3">
                    <strong>Requirements:</strong>
                    <ul class="small mb-0">
                        @foreach($requirements as $key => $value)
                            @if(is_string($key) && is_string($value))
                            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge 
                        @if($program->is_open) bg-success
                        @else bg-danger @endif">
                        @if($program->is_open) Open for Applications
                        @else Closed @endif
                    </span>
                    
                    <small class="text-muted">
                        {{ $program->applications_count ?? 0 }} applications
                    </small>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('programs.show', $program) }}" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-info-circle me-1"></i> View Details
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($programs->count() === 0)
<div class="text-center py-5">
    <i class="fas fa-graduation-cap fa-4x text-muted mb-3"></i>
    <h5 class="text-muted">No scholarship programs available at the moment.</h5>
</div>
@endif
@endsection