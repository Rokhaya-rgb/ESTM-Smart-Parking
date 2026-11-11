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

        // Le mélange reste équilibré : toujours entre ~30 % et ~70 % de places occupées parmi les simulées,
        // pour que les places alternent réellement entre libre et occupée (jamais toutes pleines ni toutes vides).
        $n = $slots->count();
        $min = (int) floor($n * 0.3);
        $max = (int) ceil($n * 0.7);
        $occupied = $slots->where('status', 'occupied')->count();

        foreach ($slots->shuffle() as $slot) {
            $before = $slot->status;
            $after = $before === 'occupied' ? 'available' : 'occupied';
            $newOccupied = $occupied + ($after === 'occupied' ? 1 : -1);

            // Capteur « vivant » : il se signale à chaque passage, même sans changement
            if (random_int(1, 100) > $chance || $newOccupied < $min || $newOccupied > $max) {
                $slot->update(['last_detection' => now()]);
                continue;
            }

            $occupied = $newOccupied;

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
