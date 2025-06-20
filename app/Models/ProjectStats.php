<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectStats extends Model
{
    protected $fillable = [
        'project_id',
        'budget_init',
        'budget_current',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
