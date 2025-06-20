<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request extends Model
{

    protected $fillable = [
        'name',
        'description',
        'ticket_id',
        'responsible_id',
        'status_id',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(RequestStatus::class, 'status_id', 'id');
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id', 'id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }
}
