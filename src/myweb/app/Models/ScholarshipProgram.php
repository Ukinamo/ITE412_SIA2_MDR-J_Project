<?php
// app/Models/ScholarshipProgram.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'amount', 'deadline', 'requirements', 'is_active'
    ];

    protected $casts = [
        'requirements' => 'array',
        'deadline' => 'date',
        'amount' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function applications()
    {
        return $this->hasMany(ScholarshipApplication::class, 'program_id');
    }

    public function activeApplications()
    {
        return $this->applications()->whereIn('status', ['pending', 'under_review']);
    }

    public function getIsOpenAttribute()
    {
        return $this->is_active && $this->deadline > now();
    }
}