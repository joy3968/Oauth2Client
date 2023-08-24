<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// TODO : 고객사 인증 시스템 (IdP)

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/redirect', function (Request $request) {
//    $request->session()->put('state', $state = Str::random(40));
//
//    // Authorization Code 발급 요청.
//    $query = http_build_query([
//        'client_id' => '982665d9-dddb-46bb-8bcd-6484a9354952', // TODO client_id 는 따로 입력 받는다. (DB에 저장)
//        'redirect_uri' => 'http://homestead.test/callback', // 저장한 redirect 와 맞는지 검증을 함.
//        'response_type' => 'code',
//        'scope' => '',
//        'state' => $state,
//    ]);
//
//    return redirect('http://client.homestead.test/oauth/authorize?'.$query); // Authorization Code 발급.
//});

Route::post('/authuser', function (Request $request) {
    $access_token = $request->get('access_token');

    // 사용자 측에서 직접 접근.
    $response = Http::withHeaders([
        "Accept" => "application/json",
        "Authorization" => "Bearer " . $access_token
    ])->get("http://client.homestead.test/api/user");

    return $response->json();
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
