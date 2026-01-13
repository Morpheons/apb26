<?php

namespace App\Models;

use Guava\Calendar\ValueObjects\CalendarEvent;
use Guava\Calendar\ValueObjects\FetchInfo;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'title',
        'starts_at',
        'ends_at',
        'locations_from',
        'locations_to',
        'description'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'locations_from' => 'array',
        'locations_to' => 'array',
    ];
    public function getEvents(FetchInfo $info)
    {
        return Appointment::query()
            ->select(['id', 'title', 'starts_at', 'ends_at', 'locations_from', 'locations_to'])
            ->where('starts_at', '>=', $info->start)
            ->get()
            ->map(fn (Appointment $appointment) =>
            CalendarEvent::make($appointment)
                ->title($appointment->title)
                ->start($appointment->starts_at)
                ->end($appointment->starts_at->addHour())
                ->key($appointment->id)
            );
    }
}
