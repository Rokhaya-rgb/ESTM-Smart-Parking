<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Http;
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
            $forwardUrl = config('mqtt.forward_url');

            if ($forwardUrl) {
                // Mode VPS : le site (mutualisé) reste seul à écrire en base
                $response = Http::withToken((string) config('esp32.ingest_key'))
                    ->acceptJson()
                    ->timeout(5)
                    ->post($forwardUrl, ['topic' => $topic, 'message' => (string) $message]);

                if ($response->failed()) {
                    Log::warning("Relais {$topic} refusé par le site : HTTP " . $response->status());
                }
                return;
            }

            // Mode local : écriture directe en base
            app(ParkingIngestService::class)->handle($topic, (string) $message);
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
