<!-- resources/views/admin/users/index.blade.php -->
@extends('admin.layouts.app')

@section('title', 'User Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-users me-2"></i>User Management</h4>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger">
        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
    </a>
</div>

<div class="card border-danger">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">System Users</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Applications</th>
                        <th>Evaluations</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <strong>{{ $user->name }}</strong>
                            @if($user->id === Auth::id())
                            <span class="badge bg-info ms-1">You</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="d-inline">
                                @csrf
                                <select name="role" class="form-select form-select-sm" 
                                        onchange="this.form.submit()" 
                                        {{ $user->id === Auth::id() ? 'disabled' : '' }}>
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Student</option>
                                    <option value="viewer" {{ $user->role == 'viewer' ? 'selected' : '' }}>Reviewer</option>
                                    {{-- <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option> --}}
                                </select>
                            </form>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $user->applications_count }}</span>
                        </td>
                        <td>
                            <span class="badge bg-warning">{{ $user->evaluations_count }}</span>
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($user->id !== Auth::id())
                            <a href="{{ route('admin.messages.create') }}?to={{ $user->id }}" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-envelope"></i> Message
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <h6>Role Summary</h6>
            <div class="row text-center">
                <div class="col-md-6">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h4>{{ $users->where('role', 'user')->count() }}</h4>
                            <p class="mb-0">Students</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h4>{{ $users->where('role', 'viewer')->count() }}</h4>
                            <p class="mb-0">Reviewers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection