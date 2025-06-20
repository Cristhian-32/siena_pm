<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Deliverable extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'ticket_id',
        'status_id',
        'budget_used',
    ];

    protected $appends = [
        'deliverable'
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(DeliverableStatus::class, 'status_id', 'id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }


    protected function deliverable(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl('deliverable')
        );
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('deliverable')->singleFile();
    }
}
