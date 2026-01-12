<?php

namespace App\Models;

use Guava\Calendar\ValueObjects\CalendarEvent;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'title',
        'starts_at',
        'ends_at',
        'address',
        'latitude',
        'longitude',
        'description'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
    public function getEvents(FetchInfo $info): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        return Appointment::query()
            ->select(['id', 'title', 'starts_at', 'address', 'start_address','latitude','longitude'])
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
