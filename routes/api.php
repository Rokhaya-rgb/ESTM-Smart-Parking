<?php

use App\Http\Controllers\Api\MqttIngestController;
use Illuminate\Support\Facades\Route;

// Relais VPS -> site : POST /api/mqtt  (Authorization: Bearer <INGEST_API_KEY>)
Route::post('/mqtt', MqttIngestController::class)->middleware('throttle:600,1');
