<?php

use Illuminate\Http\Request;

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
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user', function (Request $request) {
    $array = [
        'user_id' => $request->user()->id,
        'email' => $request->user()->email,
        'name' => $request->user()->name,
    ];
    return $array;
})->middleware('auth:api');
