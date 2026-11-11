<?php

return [
    'esp32_key' => env('ESP32_API_KEY', 'votre-clé-secrète-ici'),
    // Clé partagée entre l'écouteur MQTT (VPS) et le site (mutualisé)
    'ingest_key' => env('INGEST_API_KEY', ''),
];
