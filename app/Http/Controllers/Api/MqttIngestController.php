<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ParkingIngestService;
use Illuminate\Http\Request;

/**
 * Point d'entrée HTTP du site : reçoit les messages MQTT relayés par l'écouteur du VPS.
 */
class MqttIngestController extends Controller
{
    public function __invoke(Request $request, ParkingIngestService $ingest)
    {
        $expected = (string) config('esp32.ingest_key');
        $given = (string) $request->bearerToken();

        // Clé absente ou laissée à la valeur d'exemple : on refuse tout.
        if ($expected === '' || $expected === 'votre-clé-secrète-ici' || ! hash_equals($expected, $given)) {
            abort(401, 'Unauthorized');
        }

        $data = $request->validate([
            'topic' => ['required', 'string', 'max:255', 'regex:#^parking/(slot/[A-Za-z0-9_-]+|total)$#'],
            'message' => ['required', 'string', 'max:64'],
        ]);

        $ingest->handle($data['topic'], $data['message']);

        return response()->json(['ok' => true]);
    }
}
