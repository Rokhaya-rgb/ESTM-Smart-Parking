<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function update(Request $request, $slot_code)
    {
        $slot = ParkingSlot::where('slot_code', $slot_code)->firstOrFail();

        $validated = $request->validate([
            'status' => 'required|in:available,occupied',
        ]);

        $status_before = $slot->status;
        $slot->update([
            'status' => $validated['status'],
            'last_detection' => now(),
        ]);

        $slot->slotEvents()->create([
            'status_before' => $status_before,
            'status_after' => $validated['status'],
            'detected_at' => now(),
            'source' => 'esp32',
        ]);

        return response()->json(['message' => 'Slot updated successfully']);
    }
}
