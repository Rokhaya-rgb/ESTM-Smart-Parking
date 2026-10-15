use App\Http\Controllers\Api\SlotController;

Route::post('/slots/{slot}', [SlotController::class, 'update']);