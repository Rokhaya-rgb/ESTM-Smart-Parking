<?php

namespace App\Livewire;

use App\Models\SlotEvent;
use Livewire\Component;
use Livewire\WithPagination;

class SlotHistory extends Component
{
    use WithPagination;

    public function render()
    {
        $events = SlotEvent::with('parkingSlot')
            ->orderBy('detected_at', 'desc')
            ->paginate(20);

        return view('livewire.slot-history', ['events' => $events])
            ->layout('layouts.app');
    }
}
