<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\ParkingSlot;
use App\Events\ParkingSlotUpdated;
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

            $connectionSettings = new ConnectionSettings();
            $connectionSettings
                ->setKeepAliveInterval(60)
                ->setConnectTimeout(3)
                ->setUseTls(false);

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
            $this->client->subscribe('parking/slot/#', function ($topic, $message) {
                Log::info("Received message on topic {$topic}: {$message}");
                $this->handleMessage($topic, $message);
            }, 0);

            Log::info('Subscribed to MQTT topics');
        } catch (\Exception $e) {
            Log::error('MQTT Subscribe failed: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function handleMessage($topic, $message)
    {
        try {
            $slotCode = substr($topic, strrpos($topic, '/') + 1);
            $status = strtolower($message) === 'occupied' ? 'occupied' : 'available';

            $slot = ParkingSlot::where('slot_code', $slotCode)
                              ->where('has_sensor', true)
                              ->first();

            if ($slot) {
                $slot->update([
                    'status' => $status,
                    'last_detection' => now()
                ]);

                event(new ParkingSlotUpdated($slot));
                Log::info("Updated slot {$slotCode} status to {$status}");
            } else {
                Log::warning("Slot {$slotCode} not found or does not have a sensor");
            }
        } catch (\Exception $e) {
            Log::error('Error handling MQTT message: ' . $e->getMessage());
        }
    }

    public function getClient()
    {
        return $this->client;
    }
}
