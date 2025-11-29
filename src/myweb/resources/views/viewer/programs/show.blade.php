<!-- resources/views/viewer/programs/show.blade.php -->
@extends('viewer.layouts.app')

@section('title', $program->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-viewer">
            <div class="card-header card-header-viewer">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $program->name }}</h4>
                    <span class="badge 
                        @if($program->is_open) bg-light text-dark
                        @else bg-secondary @endif">
                        @if($program->is_open) Open
                        @else Closed @endif
                    </span>
                </div>
            </div>
            <div class="card-body">
                <h5 class="text-warning mb-3">Description</h5>
                <p class="mb-4">{{ $program->description }}</p>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h3 class="text-success">${{ number_format($program->amount, 2) }}</h3>
                                <p class="mb-0 text-muted">Scholarship Amount</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h3 class="
                                    @if($program->deadline->isPast()) text-danger
                                    @elseif($program->deadline->diffInDays(now()) < 7) text-warning
                                    @else text-primary @endif">
                                    {{ $program->deadline->format('M d, Y') }}
                                </h3>
                                <p class="mb-0 text-muted">Application Deadline</p>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $requirements = $program->requirements;
                @endphp

                @if(!empty($requirements) && is_array($requirements))
                <h5 class="text-warning mb-3">Requirements</h5>
                <div class="card mb-4">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($requirements as $key => $value)
                                @if(is_string($key) && is_string($value))
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{ $key }}:</strong>
                                    <span class="text-end">{{ $value }}</span>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-viewer">
            <div class="card-header card-header-viewer">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Program Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Program Status:</strong> 
                    <span class="badge {{ $program->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $program->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
                <p><strong>Total Applications:</strong> {{ $program->applications->count() }}</p>
                <p><strong>Created:</strong> {{ $program->created_at->format('F d, Y') }}</p>
                <p><strong>Last Updated:</strong> {{ $program->updated_at->format('F d, Y') }}</p>

                <a href="{{ route('programs.index') }}" class="btn btn-outline-secondary w-100 mt-3">
                    <i class="fas fa-arrow-left me-2"></i>Back to Programs
                </a>
            </div>
        </div>

        <div class="card card-viewer mt-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Program Statistics</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Days until deadline:</span>
                    <span class="badge 
                        @if($program->deadline->isPast()) bg-danger
                        @elseif($program->deadline->diffInDays(now()) < 7) bg-warning
                        @else bg-success @endif">
                        {{ max(0, $program->deadline->diffInDays(now())) }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Accepting applications:</span>
                    <span class="badge {{ $program->is_open ? 'bg-success' : 'bg-danger' }}">
                        {{ $program->is_open ? 'Yes' : 'No' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection