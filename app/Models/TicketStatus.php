<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketStatus extends Model
{
    protected $fillable = [
        'name',
        'color',
        'is_default',
        'order',
        'project_id'
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'status_id', 'id');
    }
}
