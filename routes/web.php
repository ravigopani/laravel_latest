<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

/***** Callback function *****/
Route::get('/test1', function () {
    return 'return from web.php';
});

/***** New method *****/
// use App\Http\Controllers\TestController;
// Route::get('/test2', [TestController::class, 'testFunction1']);

/***** Old method *****/
Route::get('/test2','TestController@testFunction1');

/***** Visit RouteService Provider File to setup changes for route file *****/

/***** Supported HTTP request types *****/
// Route::get($uri, $callback);
// Route::post($uri, $callback);
// Route::put($uri, $callback);
// Route::patch($uri, $callback);
// Route::delete($uri, $callback);
// Route::options($uri, $callback);

Route::match(['get', 'post'], '/test3', function () {
});
Route::any('/test4', function () {
});

/***** Dependency Injection *****/
Route::get('/test5', function (Request $request) {
    return 'test5 route called';
});

/***** Route redirect *****/
Route::redirect('/test6', '/test5'); // by default redirect on 302 if not found

/***** Route view *****/
Route::view('/test7', 'view1', ['name' => 'Taylor']);

/***** Required parameters *****/
Route::get('/test8/{id}', function ($id) {
    return 'Test8 called -> Parameter - '.$id;
});

Route::get('/test9/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Test9 called -> posts - '.$postId.' -> comments - '.$commentId;
});

Route::get('/test10/{id}', function (Request $request, $id) {
    return 'Test10 called -> Parameter - '.$id;
});

Route::get('/test11/{name?}', function ($name = 'John') {
    return 'Test11 called -> Parameter - '.$name;
});

Route::get('/test12/{name?}', function ($name = 'John') {
    return 'Test12 called -> Parameter - '.$name;
});

Route::get('/test13/{name}', function ($name) {
})->where('name', '[A-Za-z]+');

Route::get('/test14/{id}', function ($id) {
})->where('id', '[0-9]+');

Route::get('/test15/{id}/{name}', function ($id, $name) {
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);

Route::get('/test16/{id}/{name}', function ($id, $name) {
})->whereNumber('id')->whereAlpha('name');

Route::get('/test17/{name}', function ($name) {
})->whereAlphaNumeric('name');

Route::get('/test18/{id}', function ($id) {
})->whereUuid('id');

