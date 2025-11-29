<!-- resources/views/admin/programs/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Scholarship Programs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-graduation-cap me-2"></i>Scholarship Programs</h4>
    <a href="{{ route('admin.programs.create') }}" class="btn btn-admin">
        <i class="fas fa-plus-circle me-2"></i>Create New Program
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    @foreach($programs as $program)
    <div class="col-md-6 mb-4">
        <div class="card card-admin h-100">
            <div class="card-header card-header-admin d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $program->name }}</h5>
                <span class="badge {{ $program->is_active ? 'bg-success' : 'bg-danger' }}">
                    {{ $program->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $program->description }}</p>
                
                <div class="mb-3">
                    <strong>Amount:</strong> 
                    <span class="badge bg-success">₱{{ number_format($program->amount, 2) }}</span>
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
                <div class="d-flex justify-content-between">
                    <a href="{{ route('programs.show', $program) }}" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-eye me-1"></i> View
                    </a>
                    
                    <a href="{{ route('admin.applications.index') }}?program={{ $program->id }}" 
                       class="btn btn-sm btn-outline-info">
                        <i class="fas fa-list me-1"></i> Applications
                    </a>

                    <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($programs->count() === 0)
<div class="text-center py-5">
    <i class="fas fa-graduation-cap fa-4x text-muted mb-3"></i>
    <h5 class="text-muted">No scholarship programs available at the moment.</h5>
    <a href="{{ route('admin.programs.create') }}" class="btn btn-admin mt-3">
        <i class="fas fa-plus-circle me-2"></i>Create First Program
    </a>
</div>
@endif
@endsection