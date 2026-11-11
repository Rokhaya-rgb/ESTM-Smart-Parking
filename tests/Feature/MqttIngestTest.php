<?php

namespace Tests\Feature;

use App\Models\ParkingMetric;
use App\Models\ParkingSlot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MqttIngestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['esp32.ingest_key' => 'cle-de-test']);
    }

    public function test_refuse_sans_cle(): void
    {
        $this->postJson('/api/mqtt', ['topic' => 'parking/total', 'message' => '3'])
            ->assertStatus(401);
    }

    public function test_refuse_si_cle_non_configuree(): void
    {
        config(['esp32.ingest_key' => '']);

        $this->withToken('')->postJson('/api/mqtt', ['topic' => 'parking/total', 'message' => '3'])
            ->assertStatus(401);
    }

    public function test_met_a_jour_le_compteur(): void
    {
        $this->withToken('cle-de-test')
            ->postJson('/api/mqtt', ['topic' => 'parking/total', 'message' => '4'])
            ->assertOk();

        $this->assertSame('4', ParkingMetric::read('vehicle_count'));
    }

    public function test_refuse_un_topic_inattendu(): void
    {
        $this->withToken('cle-de-test')
            ->postJson('/api/mqtt', ['topic' => 'autre/chose', 'message' => 'x'])
            ->assertStatus(422);
    }

    public function test_met_a_jour_une_place(): void
    {
        ParkingSlot::forceCreate(['slot_code' => 'A1', 'has_sensor' => true, 'status' => 'available']);

        $this->withToken('cle-de-test')
            ->postJson('/api/mqtt', ['topic' => 'parking/slot/A1', 'message' => 'occupied'])
            ->assertOk();

        $this->assertSame('occupied', ParkingSlot::where('slot_code', 'A1')->first()->status);
    }
}
