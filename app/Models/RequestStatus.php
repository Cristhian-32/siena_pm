<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestStatus extends Model
{
    protected $fillable = [
        'name',
        'color',
        'is_default',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Request::class, 'status_id', 'id');
    }
}
