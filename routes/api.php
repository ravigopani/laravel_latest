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

// php artisan make:resource UserResource // eloquent relationship
// php artisan make:resource User --collection 
// dont get too much of knowledge -- find more about it

// Laravel Sanctum
// solve problems of -> API Tokens & SPA Authentication


// API Versioning
// protected $apiNamespace ='App\Http\Controllers\Api';
// Route::group([
//     'middleware' => ['api', 'api_version:v1'],
//     'namespace'  => "{$this->apiNamespace}\V1",
//     'prefix'     => 'api/v1',
// ], function ($router) {
//     require base_path('routes/api_v1.php');
// });

// Route::group([
//     'middleware' => ['api', 'api_version:v2'],
//     'namespace'  => "{$this->apiNamespace}\V2",
//     'prefix'     => 'api/v2',
// ], function ($router) {
//     require base_path('routes/api_v2.php');
// });