<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
    protected $fillable = [
        'slot_code',
        'status',
        'last_detection',
        'is_reserved',
        'reserved_for'
    ];

    protected $casts = [
        'last_detection' => 'datetime',
        'is_reserved' => 'boolean'
    ];

    public function slotEvents()
    {
        return $this->hasMany(SlotEvent::class);
    }
}
