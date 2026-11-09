<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MqttService;

class MqttListen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var stringranchement
     * 
     */
    protected $signature = 'mqttlisten';

    /**
     *
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start listening for MQTT messages';

    /**
     * Execute the console command.
     */
    public function handle(MqttService $mqtt)
    {
        $this->info('Starting MQTT listener...');

        try {
            $mqtt->connect();
            $this->info('Connected to MQTT broker');

            $mqtt->subscribe();
            $this->info('Subscribed to topics');

            // Méthode recommandée : bloquante
            $mqtt->getClient()->loop(true);

        } catch (\Exception $e) {
            $this->error('MQTT Error: ' . $e->getMessage());
            return 0;
        }
    }
}
