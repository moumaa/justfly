<?php

namespace App\Models;

use \DateTimeZone;
use \DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Flight extends Model
{
    use HasFactory;

    protected $table = 'flights';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'airline_id',
        'number',
        'departure_airport_id',
        'departure_time',
        'arrival_airport_id',
        'arrival_time',
        'price'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'airline_id' => 'int',
            'number' => 'int',
            'departure_airport_id' => 'int',
            'departure_time' => 'datetime',
            'arrival_airport_id' => 'int',
            'arrival_time' => 'datetime',
            'price' => 'float',
        ];
    }

    public function airline(): BelongsTo{
        return $this->belongsTo(Airline::class, 'airline_id');
    }

    public function departedFromAirport(): HasOne{
        return $this->hasOne(Airport::class, 'id', 'departure_airport_id');
    }

    public function arrivedAtAirport(): HasOne{
        return $this->hasOne(Airport::class, 'id', 'arrival_airport_id');
    }

    public function getFlightTimeAttribute()
    {
        //get time difference between the arrival and the departure
        $timeFirst  = strtotime($this->departure_time);
        $timeSecond = strtotime($this->arrival_time);
        $differenceInSeconds = $timeSecond - $timeFirst;

        //get time difference between the two timezones
        $departureTimeZone = new DateTimeZone($this->departedFromAirport->timezone);
        $departureTime = new DateTime('now', $departureTimeZone);
        $arrivalTimeZone = new DateTimeZone($this->arrivedAtAirport->timezone);
        $arrivalTime = new DateTime('now', $arrivalTimeZone);

        $departureTimeOffset = $departureTime->getOffset();
        $arrivalTimeOffset = $arrivalTime->getOffset();
        $intervalForTimeZoneInSeconds = $arrivalTimeOffset - $departureTimeOffset;


        $totalFlightTimeInSeconds = $differenceInSeconds-$intervalForTimeZoneInSeconds;

        return gmdate("H:i:s", $totalFlightTimeInSeconds);
    }
}
