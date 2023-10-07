<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FishController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => ''], function () {
    Route::get('/', function () {
        return Response()->json([
            'status' => false, 'errorCode' => 401, 'errorDescription' => 'N/A - Bad Link'], 200)->header('Content-Type', 'application/json');

    });

    Route::post('/', function () {
        return Response()->json(['status' => false, 'errorCode' => 401, 'errorDescription' => 'N/A - Bad Links'], 200)->header('Content-Type', 'application/json');

    });

    Route::get('/btc', [Controller::class, 'index']);


});
Route::prefix('/fish/v2')->group(function (){
    Route::get('/on', [FishController::class, 'openlink']);
    Route::get('/off', [FishController::class, 'closelink']);
    Route::get('/expire', [FishController::class, 'autoShutoff']);
});

Route::prefix('/coin/v2')->middleware(['throttle:100,1'])->group(function (){
   // Route::post('/login', [ApiController::class, 'loginUser']);
   // Route::post('/register', [ApiController::class, 'registerUser']);
});
