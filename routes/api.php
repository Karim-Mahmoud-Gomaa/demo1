<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    CampaignsController,
};
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

//////////////////////////////////////////////////////////////
Route::post('login', [AuthController::class,'login']);

Route::group(["middleware" => ["auth:api"]], function(){
    Route::post('logout', [AuthController::class,'logout']);
    Route::get('user', [AuthController::class,'user']);
    Route::post('upload-image', [CampaignsController::class,'uploadImage']);
    Route::post('remove-image', [CampaignsController::class,'RemoveImage']);
    
    Route::resource('campaigns', CampaignsController::class);
});
//////////////////////////////////////////////////////////////



