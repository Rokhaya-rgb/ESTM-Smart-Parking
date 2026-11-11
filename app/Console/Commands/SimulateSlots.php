<?php

namespace App\Console\Commands;

use App\Models\ParkingSlot;
use Illuminate\Console\Command;

/**
 * Simule des capteurs infrarouges sur les places qui n'en ont pas de réel :
 * de temps en temps une place passe de libre à occupée, ou l'inverse, avec un événement d'historique.
 */
class SimulateSlots extends Command
{
    protected $signature = 'parking:simulate {--loop : tourner en continu} {--every=10 : secondes entre deux passages en mode --loop}';

    protected $description = 'Simule les capteurs des places sans capteur réel';

    public function handle(): int
    {
        if (! config('parking.simulate')) {
            $this->warn('Simulation désactivée (PARKING_SIMULATE=false).');
            return self::SUCCESS;
        }

        do {
            $changed = $this->tick();
            if ($this->option('loop')) {
                $this->line(now()->format('H:i:s') . " : {$changed} changement(s)");
                sleep(max(1, (int) $this->option('every')));
            }
        } while ($this->option('loop'));

        return self::SUCCESS;
    }

    protected function tick(): int
    {
        $chance = max(0, min(100, (int) config('parking.simulate_chance')));
        $changed = 0;

        $slots = ParkingSlot::where('is_reserved', false)
            ->whereNotIn('slot_code', config('parking.real_sensor_slots'))
            ->get();

        foreach ($slots as $slot) {
            // Capteur « vivant » : il se signale à chaque passage, même sans changement
            if (random_int(1, 100) > $chance) {
                $slot->update(['last_detection' => now()]);
                continue;
            }

            $before = $slot->status;
            $after = $before === 'occupied' ? 'available' : 'occupied';

            $slot->update(['status' => $after, 'last_detection' => now()]);
            $slot->slotEvents()->create([
                'status_before' => $before,
                'status_after' => $after,
                'detected_at' => now(),
                'source' => 'simulation',
            ]);
            $changed++;
        }

        return $changed;
    }
}
