<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'type',
        'event_date',
        'organizer',
        'image',
        'instagram_url',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_date' => 'datetime',
        ];
    }

    /**
     * Accessor for automatic event status (Selesai vs Coming Soon).
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->event_date && Carbon::now()->greaterThan($this->event_date) ? 'Selesai' : 'Coming Soon'
        );
    }
}
