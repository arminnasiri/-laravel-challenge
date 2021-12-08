<?php

use App\Http\Controllers\Api\V1\MobileController;
use App\Http\Controllers\Api\V1\PosController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\WebController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('transactions',[ReportController::class, 'lastMonth']);
Route::group([
    "prefix" => "transaction"
], function () {
     Route::post("pos",PosController::class);
     Route::post("web",WebController::class);
     Route::post("mobile",MobileController::class);
});
