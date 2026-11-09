<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\ParkingSlot;
use App\Models\ParkingMetric;
use Illuminate\Support\Facades\Log;

class MqttService
{
    protected $client;
    protected $host;
    protected $port;
    protected $clientId;

    public function __construct()
    {
        $this->host = config('mqtt.host', '127.0.0.1'); // IP de Mosquitto
        $this->port = config('mqtt.port', 1883);
        $this->clientId = config('mqtt.client_id', 'laravel_parking_' . uniqid());
    }

    public function connect()
    {
        try {
            $this->client = new MqttClient($this->host, $this->port, $this->clientId);

            // ConnectionSettings est immuable : chaque setter renvoie une copie,
            // il faut donc réaffecter le résultat (sinon les identifiants sont perdus).
            $connectionSettings = (new ConnectionSettings())
                ->setKeepAliveInterval((int) config('mqtt.keep_alive', 60))
                ->setConnectTimeout((int) config('mqtt.timeout', 5))
                ->setUseTls(false);

            $username = config('mqtt.username');
            if ($username !== null && $username !== '') {
                $connectionSettings = $connectionSettings
                    ->setUsername($username)
                    ->setPassword(config('mqtt.password'));
            }

            $this->client->connect($connectionSettings, true);
            Log::info('Connected to MQTT broker at ' . $this->host);
        } catch (\Exception $e) {
            Log::error('MQTT Connection failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function subscribe()
    {
        try {
            foreach (['parking/slot/#', 'parking/total'] as $filter) {
                $this->client->subscribe($filter, function ($topic, $message) {
                    $this->handleMessage($topic, $message);
                }, 0);
            }

            Log::info('Subscribed to MQTT topics');
        } catch (\Exception $e) {
            Log::error('MQTT Subscribe failed: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function handleMessage($topic, $message)
    {
        try {
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

            if ($slot) {
                $before = $slot->status;
                $slot->update([
                    'status' => $status,
                    'last_detection' => now()
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
            } else {
                Log::warning("Slot {$slotCode} not found or does not have a sensor");
            }
        } catch (\Exception $e) {
            Log::error('Error handling MQTT message: ' . $e->getMessage());
        }
    }

    public function loop(): void
    {
        $this->client->loop(true);
    }

    public function getClient()
    {
        return $this->client;
    }
}
