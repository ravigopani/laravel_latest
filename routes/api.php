<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test_api', 'TestController@test_api');
Route::apiResource('test_api_resource', 'TestController');

// Route::apiResources([
//     'photos' => PhotoController::class,
//     'posts' => PostController::class,
// ]);

// /photos/{photo}/comments/{comment}
// Route::resource('photos.comments', TestController::class);

// default routes
// Route::get($uri, $callback);
// Route::post($uri, $callback);
// Route::put($uri, $callback);
// Route::patch($uri, $callback);
// Route::delete($uri, $callback);
// Route::options($uri, $callback);
