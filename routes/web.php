<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

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

/***** Welcome page Route *****/
Route::get('/', function () {
    return view('welcome');
});

/***** Default Auth Package Routes *****/
/* Run Command to get default authentication of user */
// composer require laravel/ui
// php artisan ui vue --auth
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/***** Callback function *****/
Route::get('/route_1', function () {
    return 'return from web.php';
});

/***** New method *****/
// use App\Http\Controllers\TestController;
// Route::get('/route_2', [TestController::class, 'testFunction1']);

/***** Old method *****/
Route::get('/route_2','TestController@testFunction1');

/***** Visit RouteService Provider File to setup changes for route file *****/

/***** Supported HTTP request types *****/
// Route::get($uri, $callback);
// Route::post($uri, $callback);
// Route::put($uri, $callback);
// Route::patch($uri, $callback);
// Route::delete($uri, $callback);
// Route::options($uri, $callback);

Route::match(['get', 'post'], '/route_3', function () {
});
Route::any('/route_4', function () {
});

/***** Dependency Injection *****/
Route::get('/route_5', function (Request $request) {
    return 'route_5 route called';
});

/***** Route redirect *****/
Route::redirect('/route_6', '/route_5'); // by default redirect on 302 if not found

/***** Route view *****/
Route::view('/route_7', 'view1', ['name' => 'Taylor']);

/***** Required parameters *****/
Route::get('/route_8/{id}', function ($id) {
    return 'route_8 called -> Parameter - '.$id;
});
Route::get('/route_9/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'route_9 called -> posts - '.$postId.' -> comments - '.$commentId;
});
/***** Parameters & Dependency Injection *****/
Route::get('/route_10/{id}', function (Request $request, $id) {
    return 'route_10 called -> Parameter - '.$id;
});

/***** Optional Parameters *****/
Route::get('/route_11/{name?}', function ($name = 'John') {
    return 'route_11 called -> Parameter - '.$name;
});
Route::get('/route_12/{name?}', function ($name = 'John') {
    return 'route_12 called -> Parameter - '.$name;
});

/***** Regular Expression Constraints *****/
Route::get('/route_13/{id}', function ($id) {
})->where('id', '[0-9]+');
Route::get('/route_14/{id}/{name}', function ($id, $name) {
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
Route::get('/route_15/{id}/{name}', function ($id, $name) {
})/* ->whereUuid('id')->whereAlphaNumeric('name') */->whereNumber('id')->whereAlpha('name');


/***** Encoded Forward Slashes *****/
Route::get('/route_16/{search}', function ($search) {
    return $search;
})->where('search', '.*')/* ->where('search', 'abcd') */;

/***** Named Routes *****/
Route::get('/route_17/{id}', function () {    
})->name('route_17');
// Use of Named routes
// $url = route('profile', ['id'=>1] ); // Generating URLs...
// return redirect()->route('profile'); // Generating Redirects...
// $request->route()->named('profile')  // check is current route is named route

Route::get('/route_18/{id}/profile', function (Request $request,$id) {
    return [$id,$request->toArray()];
})->name('route_18')/* ->name('admin.route_18') */;
// $url = route('route_18', ['id' => 1, 'photos' => 'yes']);
// here with `.` we can make group of admin named routes and can use in group of routes.
// /user/1/profile?photos=yes //photos parameter set as behind get request

/***** Route Grouping *****/
Route::middleware(['first', 'second'])
    ->domain('{account}.example.com')
    ->name('admin.')
    ->prefix('test_prefix')
    ->group(function () {
    Route::get('/route_19', function () {});
});

// we can use with this array format also
Route::group([
        ['middleware'=>['first','second']],
        ['prefix'=>'test_prefix'],
        ['name' => 'admin.'],
    ],
    function(){
        Route::get('/route_19', function () {});
    }
);

/***** Route Model Binding [Implicit Binding]*****/
// `Implicit Binding` with User class here in callback function
Route::get('/route_20/{user}', function (User $user) {
    return $user->email;
})/* ->withTrashed(); */;
//  call url -> /route_20/1 // by default param expact `id` in model binding
//  but we can modify it with `getRouteKeyName()` function in Model class file.
// withTrashed() -> get all softdeleted data

// Customizing The Key
Route::get('/route_23/{param:name}', function (User $param) {
    return $param->email;
});

// id test22/{user_id} not found or missing then redirect on specfic fallback function 
Route::get('/route_24/{param}', function (User $param) {
    return $param->email;
})->missing(function (Request $request) {
    return redirect('route_1');
});

/***** Route Model Binding [Explicit Binding]*****/
// `Explicit Binding` with Bind model with param keyword in RouteServiceProvider
Route::get('/route_21/{user}', function ($user) {
    return $user->email;
});
// removing class name we can call user class with explicit binding inside RouteServiceProvider
// put this in boot() of RouteServiceProvider -> Route::model('user', User::class);

// custom explicit binding with see in RouteServiceProvider
Route::get('/route_22/{custom_user}', function ($user) {
    return $user->email;
});

// we can also use like this
// Route::get('/users/{param1}/posts/{param2:slug}', function (User $param1, Post $param2) {
//     return $param1;
//     return $param2;
// });

/***** Fallback Route *****/
Route::fallback(function () {
    return 'Fallback Route';
});
// use for is route is not found call automatic this route instead 404 error page.
// BASE_URL + { abcd } // like only if abcd not found
// BASE_URL + { users } + `1234` // not for `1234` user of id not found from user table in model binding 

/***** Accessing current route *****/
// $route = Route::current(); // Illuminate\Routing\Route
// $name = Route::currentRouteName(); // string
// $action = Route::currentRouteAction(); // string

/***** Middleware *****/
// Three Types of middleware
// 1) global middleware -> call on every request
// 2) group middleware -> call bunch of middleware with on alias
// 3) individual middleware -> call single middleware with on alias 

Route::get('/middleware_1', function(){
    return 'middleware_1 called';
})->middleware('test-middleware');
    /* ->middleware(['test-middleware','test-middleware']) */
    /* ->middleware(MiddlewareClass::class) */
    /* ->middleware([MiddlewareClass::class, MiddlewareClass::class,]) */

// by array method in group
Route::group(['middleware'=>['test-middleware']], function(){
    Route::get('/middleware_2', function () {
        return 'middleware_2 called';
    });
    // to exclude middleware
    Route::get('/middleware_3', function () {
        return 'middleware_3 called';
    })->withoutMiddleware('test-middleware');
});

// by function method in group
Route::middleware('test-middleware')->group(function () {
});
Route::withoutMiddleware('test-middleware')->group(function(){
});

/***** Controller - use of missing in resource controller *****/
Route::resource('photos', ResourceController::class); // normal usage of ResourceController
Route::resource('photos', ResourceController::class)
->missing(function (Request $request) {
    return redirect()->route('test1');
});
Route::resource('photos', ResourceController::class)->only([
    'index', 'show'
]);
Route::resource('photos', ResourceController::class)->except([
    'create', 'store', 'update', 'destroy'
]);

/***** Blade Template *****/
Route::get('test_view', 'TestController@test_view');
Route::get('test_blade', 'TestController@test_blade');

/***** URL *****/
Route::get('test_url_generation', 'TestController@test_url_generation');

/***** Session *****/
Route::get('test_session', 'TestController@test_session');

/***** Pagination *****/
Route::get('test_pagination', 'TestController@test_pagination');

/***** Storage *****/
Route::get('test_file_upload', 'TestController@test_file_upload');

/***** Eloquent *****/
Route::get('test_eloquent', 'TestController@test_eloquent');
Route::get('test_eloquent_relationship', 'TestController@test_eloquent_relationship');