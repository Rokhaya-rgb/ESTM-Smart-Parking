<?php

return [
    'host' => env('MQTT_HOST', '172.20.10.14'),
    'port' => env('MQTT_PORT', 1884),
    'client_id' => env('MQTT_CLIENT_ID', 'laravel_parking_' . uniqid()),
    'username' => env('MQTT_USERNAME', ''),
    'password' => env('MQTT_PASSWORD', ''),
    'clean_session' => env('MQTT_CLEAN_SESSION', true),
    'keep_alive' => env('MQTT_KEEP_ALIVE', 60),
    'timeout' => env('MQTT_TIMEOUT', 5),
    'topics' => [
        'parking/slot/#'  // Topic pour tous les messages des places de parking
    ],
    'retain' => env('MQTT_RETAIN', false),
    'qos' => env('MQTT_QOS', 0),
];