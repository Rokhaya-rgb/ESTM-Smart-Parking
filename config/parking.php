<?php

return [
    // Places équipées d'un vrai capteur infrarouge (reliées à l'ESP32). Les autres places non réservées sont simulées.
    'real_sensor_slots' => array_filter(array_map('trim', explode(',', env('PARKING_REAL_SENSORS', 'A-01,A-02,A-03,A-04')))),

    // Active la simulation des places sans capteur réel
    'simulate' => (bool) env('PARKING_SIMULATE', true),

    // Probabilité (en %) qu'une place simulée change d'état à chaque passage
    'simulate_chance' => (int) env('PARKING_SIMULATE_CHANCE', 15),
];
