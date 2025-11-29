<?php
// app/Policies/ScholarshipApplicationPolicy.php
namespace App\Policies;

use App\Models\ScholarshipApplication;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScholarshipApplicationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ScholarshipApplication $application)
    {
        return $user->role === 'admin' || 
               ($user->role === 'viewer' && $application->assigned_to === $user->id) ||
               ($user->role === 'user' && $application->user_id === $user->id);
    }

    public function update(User $user, ScholarshipApplication $application)
    {
        return $user->role === 'admin' || 
               ($user->role === 'viewer' && $application->assigned_to === $user->id);
    }

    public function delete(User $user, ScholarshipApplication $application)
    {
        return $user->role === 'admin' || 
               ($user->role === 'user' && $application->user_id === $user->id);
    }

    public function evaluate(User $user, ScholarshipApplication $application)
    {
        return $user->role === 'viewer' && $application->assigned_to === $user->id;
    }
}