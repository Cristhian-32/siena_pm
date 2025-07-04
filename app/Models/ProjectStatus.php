<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectStatus extends Model
{
    protected $fillable = [
        'name',
        'color',
        'is_default'
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'status_id', 'id');
    }
}
