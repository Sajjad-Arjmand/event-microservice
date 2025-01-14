<?php

use App\Jobs\StoreEventJob;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/api/v1/event', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|integer',
        'event_name' => 'required|string',
        'payload' => 'nullable|json'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    dispatch(new StoreEventJob($request->only(['user_id', 'event_name', 'payload'])));

    return response()->json(['success' => true], 202);
});

Route::get('/api/v1/events', function (Request $request) {
    $filters = $request->only(['user_id', 'from']);
    $limit = $request->get('limit', 10);
    $page = $request->get('page', 1);

    $cacheKey = "events_" . md5(json_encode($request->all()));

    $events = Cache::remember($cacheKey, 60, function () use ($filters, $limit, $page) {
        return Event::filter($filters)->paginate($limit, ['*'], 'page', $page);
    });

    return response()->json($events);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
