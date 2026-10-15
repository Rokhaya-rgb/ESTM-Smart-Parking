<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParkingSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Places réservées
        \App\Models\ParkingSlot::create([
            'slot_code' => 'DG-01',
            'status' => 'available',
            'last_detection' => now(),
            'is_reserved' => true,
            'reserved_for' => 'Directeur Général'
        ]);

        \App\Models\ParkingSlot::create([
            'slot_code' => 'DE-01',
            'status' => 'available',
            'last_detection' => now(),
            'is_reserved' => true,
            'reserved_for' => 'Directeur des Études'
        ]);

        // Places standards
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\ParkingSlot::create([
                'slot_code' => 'A-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'status' => 'available',
                'last_detection' => now(),
                'is_reserved' => false
            ]);
        }
    }
}
