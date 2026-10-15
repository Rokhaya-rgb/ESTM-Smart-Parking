<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlotEvent extends Model
{
    protected $fillable = [
        'slot_id',
        'status_before',
        'status_after',
        'detected_at',
        'source',
    ];

    protected $casts = [
        'detected_at' => 'datetime',
    ];

    public function parkingSlot()
    {
        return $this->belongsTo(ParkingSlot::class, 'slot_id');
    }
}
