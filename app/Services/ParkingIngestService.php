<?php

namespace App\Services;

use App\Models\ParkingMetric;
use App\Models\ParkingSlot;
use Illuminate\Support\Facades\Log;

/**
 * Applique à la base un message MQTT de la maquette (état d'une place, compteur de véhicules).
 * Utilisé par l'écouteur local (mode direct) et par l'API HTTP (mode VPS -> mutualisé).
 */
class ParkingIngestService
{
    public function handle(string $topic, string $message): void
    {
        // Signe de vie de la maquette (utilisé par le tableau de bord)
        ParkingMetric::put('esp32_last_seen', now()->toIso8601String());

        // Nombre de véhicules compté par les capteurs d'entrée/sortie
        if ($topic === 'parking/total') {
            ParkingMetric::put('vehicle_count', max(0, (int) trim($message)));
            return;
        }

        $slotCode = substr($topic, strrpos($topic, '/') + 1);
        $status = strtolower(trim($message)) === 'occupied' ? 'occupied' : 'available';

        $slot = ParkingSlot::where('slot_code', $slotCode)
            ->where('has_sensor', true)
            ->first();

        if (! $slot) {
            Log::warning("Slot {$slotCode} not found or does not have a sensor");
            return;
        }

        $before = $slot->status;
        $slot->update([
            'status' => $status,
            'last_detection' => now(),
        ]);

        // L'ESP32 republie l'état chaque seconde : on n'historise que les changements
        if ($before !== $status) {
            $slot->slotEvents()->create([
                'status_before' => $before,
                'status_after' => $status,
                'detected_at' => now(),
                'source' => 'mqtt',
            ]);
            Log::info("Slot {$slotCode}: {$before} -> {$status}");
        }
    }
}
