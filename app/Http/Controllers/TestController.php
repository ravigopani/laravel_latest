<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        info('Dont know how to use');
    }

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('log')->only('index');
        $this->middleware('subscribed')->except('store');
    }

    public function testFunction1(Request $request)
    {
        return 'testFunction1 called';

        // get CSRF token
        // $token = $request->session()->token();
        // $token = csrf_token();

        $input = $request->input(); // get all arguments in associative array
        $name = $request->input('name'); // get request data
        $name = $request->input('name', 'default'); // second arguments set default value
        $name = $request->input('products.0.name'); // in form data "dot" notation to access the arrays
        $names = $request->input('products.*.name'); // same as above
        $uri = $request->path(); // return url after base url
        $request->is('admin/*'); //  compare with url pattern
        $request->routeIs('admin.*'); // compare with route pattern
        $method = $request->method();  // get request method
        if ($request->isMethod('post')) {} // check request method
        $url = $request->url(); // get url without query string
        $urlWithQueryString = $request->fullUrl(); // get url with query string
        $request->fullUrlWithQuery(['type' => 'phone']); // append in query string data

        $value = $request->header('X-Header-Name'); // get header
        $value = $request->header('X-Header-Name', 'default'); // get header and if not then default value
        $request->hasHeader('X-Header-Name'); // check header in request

        $token = $request->bearerToken(); //retrieve a bearer token from the Authorization header
        $ipAddress = $request->ip(); // IP address of the client that made the request to your application

        $contentTypes = $request->getAcceptableContentTypes();
        if ($request->accepts(['text/html', 'application/json'])){}
        $preferred = $request->prefers(['text/html', 'application/json']);
        if ($request->expectsJson()){}

        $input = $request->all();
        $input = $request->collect();
        $request->collect('users')->each(function ($user) {
        });

        $name = $request->query('name'); // Retrieving Input From The Query String
        $name = $request->query('name', 'Helen'); // return default value
        $query = $request->query(); // retrieve all of the query string values as an associative array

        $name = $request->input('user.name'); // Retrieving JSON Input Values
        $archived = $request->boolean('archived'); // Retrieving Boolean Input Values

        $input = $request->only(['username', 'password']);
        $input = $request->only('username', 'password');
        $input = $request->except(['credit_card']);
        $input = $request->except('credit_card');

        if ($request->has('name')) {}
        if ($request->has(['name', 'email'])) {}
        $request->whenHas('name', function ($input) {});

        $request->whenHas('name', function ($input) { /* if */ }, function () { /* else */ });

        if ($request->hasAny(['name', 'email'])) {}
        if ($request->filled('name')) {}
        $request->whenFilled('name', function ($input) {});
        $request->whenFilled('name', function ($input) {}, function () {});
        if ($request->missing('name')) {}
        $request->mergeIfMissing(['votes' => 0]);
        $request->flash();
        $request->flashOnly(['username', 'email']);
        $request->flashExcept('password');

        return redirect('form')->withInput();
        return redirect()->route('user.create')->withInput();
        return redirect('form')->withInput( $request->except('password') );
        // <input type="text" name="username" value="{{ old('username') }}">
        $username = $request->old('username');
        $value = $request->cookie('name');
    }

    public function controller_1(Request $request)
    {
        return ['aaa'];
        return view('test', ['data'=>'data']);
        return view('test', compact('data'));
    }
}
