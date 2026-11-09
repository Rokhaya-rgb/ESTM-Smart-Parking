<?php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Script indépendant pour écouter MQTT hors du contexte Artisan

require __DIR__.'/vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Services\MqttService;
use Illuminate\Support\Facades\Log;

// Charger l'application Laravel mais sans démarrer HTTP
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting MQTT Listener...\n";

try {
    $mqttService = new MqttService();
    $mqttService->connect();
    $mqttService->subscribe();

    echo "Connected to MQTT broker at " . config('mqtt.host') . ":" . config('mqtt.port') . "\n";
    echo "Listening for messages on topic: parking/slot/#\n";
    echo "Press Ctrl+C to quit\n";

    // Boucle infinie pour maintenir la connexion et traiter les messages
    $mqttService->loop();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    Log::error('MQTT Listener error: ' . $e->getMessage());
    exit(1);
}