<?php

namespace App\Livewire;

use App\Models\ParkingSlot;
use Livewire\Component;

class Dashboard extends Component
{
    public function mount()
    {
        // Rafraîchissement automatique toutes les 5 secondes
        $this->js('setInterval(() => { $wire.$refresh() }, 5000);');
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
            'occupancyRate' => $totalSlots > 0 ? round(($occupiedSlots / $totalSlots) * 100) : 0
        ])->layout('layouts.app');
    }
}
