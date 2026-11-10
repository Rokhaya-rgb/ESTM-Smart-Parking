<?php

namespace App\Livewire;

use App\Models\ParkingMetric;
use App\Models\ParkingSlot;
use Livewire\Component;

class Dashboard extends Component
{
    protected function esp32Online(): bool
    {
        $seen = ParkingMetric::read('esp32_last_seen');
        return $seen && now()->diffInSeconds(\Carbon\Carbon::parse($seen), true) <= 15;
    }

    public function render()
    {
        $parkingSlots = ParkingSlot::all();
        $totalSlots = $parkingSlots->count();
        $occupiedSlots = $parkingSlots->where('status', 'occupied')->count();
        $availableSlots = $totalSlots - $occupiedSlots;
        
        return view('livewire.dashboard', [
            'parkingSlots' => $parkingSlots,
            'totalSlots' => $totalSlots,
            'occupiedSlots' => $occupiedSlots,
            'availableSlots' => $availableSlots,
            'vehicleCount' => ParkingMetric::read('vehicle_count'),
            'esp32Online' => $this->esp32Online(),
            'occupancyRate' => $totalSlots > 0 ? round(($occupiedSlots / $totalSlots) * 100) : 0
        ])->layout('layouts.app');
    }
}
