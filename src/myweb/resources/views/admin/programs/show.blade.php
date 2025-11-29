<!-- resources/views/admin/programs/show.blade.php -->
@extends('admin.layouts.app')

@section('title', $program->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-graduation-cap me-2"></i>{{ $program->name }}</h4>
    <div class="btn-group">
        <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit Program
        </a>
        <a href="{{ route('admin.programs.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Programs
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header card-header-admin">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Program Details</h5>
                    <span class="badge 
                        @if($program->is_open) bg-light text-dark
                        @else bg-secondary @endif">
                        @if($program->is_open) Open
                        @else Closed @endif
                    </span>
                </div>
            </div>
            <div class="card-body">
                <h5 class="text-danger mb-3">Description</h5>
                <p class="mb-4">{{ $program->description }}</p>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h3 class="text-success">₱{{ number_format($program->amount) }}</h3>
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
                <h5 class="text-danger mb-3">Requirements</h5>
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

                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Admin Information</h6>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-admin">
            <div class="card-header card-header-admin">
                <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Admin Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.applications.index') }}?program={{ $program->id }}" 
                   class="btn btn-outline-danger w-100 mb-2">
                    <i class="fas fa-list me-2"></i>View Applications
                </a>
                
                <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-warning w-100 mb-2">
                    <i class="fas fa-edit me-2"></i>Edit Program
                </a>

                <form action="{{ route('admin.programs.toggle-status', $program) }}" method="POST" class="mb-2">
                    @csrf
                    <button type="submit" class="btn 
                        @if($program->is_active) btn-outline-warning
                        @else btn-outline-success @endif w-100">
                        <i class="fas fa-power-off me-2"></i>
                        @if($program->is_active) Deactivate
                        @else Activate @endif
                    </button>
                </form>

                <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this program? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100" 
                            {{ $program->applications()->exists() ? 'disabled' : '' }}>
                        <i class="fas fa-trash me-2"></i>Delete Program
                    </button>
                    @if($program->applications()->exists())
                    <small class="text-muted d-block mt-1">Cannot delete program with applications</small>
                    @endif
                </form>
            </div>
        </div>

        @if($program->applications->count() > 0)
        <div class="card card-admin mt-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Application Statistics</h6>
            </div>
            <div class="card-body">
                @php
                    $statusCounts = $program->applications->groupBy('status')->map->count();
                @endphp
                @foreach($statusCounts as $status => $count)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-capitalize">{{ $status }}</span>
                    <span class="badge bg-secondary">{{ $count }}</span>
                </div>
                @endforeach
                
                <div class="mt-3 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Total:</strong>
                        <span class="badge bg-primary">{{ $program->applications->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="card card-admin mt-4">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Program Status</h6>
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
                    <span>Program active:</span>
                    <span class="badge {{ $program->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $program->is_active ? 'Yes' : 'No' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection