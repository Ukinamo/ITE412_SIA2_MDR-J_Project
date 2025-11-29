<?php
// app/Models/ScholarshipApplication.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScholarshipApplication extends Model
{
    protected $fillable = [
        'user_id',
        'program_id',
        'application_data',
        'status',
        'assigned_to',
        'admin_notes',
        'cor_file_path', // ADD THIS
        'gwa_file_path', // ADD THIS
        'recommendation_file_path', // ADD THIS
        'submitted_at' // ADD THIS
    ];

    protected $casts = [
        'application_data' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(ScholarshipProgram::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'application_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'application_id');
    }

    // Add this method to check if application has evaluation from current reviewer
    public function getHasEvaluationAttribute()
    {
        if (!auth()->check()) return false;
        
        return $this->evaluations()
            ->where('reviewer_id', auth()->id())
            ->exists();
    }

    // Add accessor methods for file paths
    public function getCorFileUrlAttribute()
    {
        return $this->cor_file_path ? Storage::disk('public')->url($this->cor_file_path) : null;
    }

    public function getGwaFileUrlAttribute()
    {
        return $this->gwa_file_path ? Storage::disk('public')->url($this->gwa_file_path) : null;
    }

    public function getRecommendationFileUrlAttribute()
    {
        return $this->recommendation_file_path ? Storage::disk('public')->url($this->recommendation_file_path) : null;
    }
}