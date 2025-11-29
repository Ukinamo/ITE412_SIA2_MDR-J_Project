<?php
// app/Models/Evaluation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    protected $fillable = [
        'application_id',
        'reviewer_id',
        'score',
        'comments',
        'criteria_scores',
        'recommendation'
    ];

    protected $casts = [
        'criteria_scores' => 'array',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(ScholarshipApplication::class, 'application_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}