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

        // Boucle de reconnexion : si le broker redémarre ou coupe, on réessaie au lieu de quitter.
        while (true) {
            try {
                $mqtt->connect();
                $this->info('Connected to MQTT broker');

                $mqtt->subscribe();
                $this->info('Subscribed to topics');

                $mqtt->loop();
            } catch (\Throwable $e) {
                $this->error('MQTT Error: ' . $e->getMessage());
                $this->warn('Nouvelle tentative dans 5 secondes...');
                sleep(5);
            }
        }
    }
}
