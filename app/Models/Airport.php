<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Airport extends Model
{
    use HasFactory;

    protected $table = 'airports';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'city_code',
        'name',
        'city',
        'country_code',
        'region_code',
        'latitude',
        'longitude',
        'timezone'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'code' => 'string',
            'name' => 'string',
            'city_id' => 'int',
            'latitude' => 'float',
            'longitude' => 'float',
            'timezone' => 'string'
        ];
    }

    public function flight(): BelongsTo{
        return $this->belongsTo(Flight::class, 'departure_airport_id');
    }

    public function location(): HasOne{
        return $this->hasOne(Location::class, 'id', 'city_id');
    }
}
