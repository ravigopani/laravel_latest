<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

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
        // $this->middleware('auth');
        // $this->middleware('log')->only('index');
        // $this->middleware('subscribed')->except('store');
    }

    public function testFunction1(Request $request)
    {
        return 'testFunction1 called';
    }

    public function test_request(Request $request)
    {
        // get request session
        $token = $request->session()->token();
        // get CSRF token
        $token = csrf_token();

        $input = $request->input(); // get all arguments in associative array
        $name = $request->input('name'); // get request data
        $name = $request->input('name', 'default'); // second arguments set default value
        $name = $request->input('products.0.name'); // in form data "dot" notation to access the arrays
        $names = $request->input('products.*.name'); // same as above
        $uri = $request->path(); // return url after base url
        $request->is('admin/*'); //  compare with url pattern
        $request->routeIs('admin.*'); // compare with route pattern
        $method = $request->method();  // get request method
        if ($request->isMethod('post')) {
        } // check request method
        $url = $request->url(); // get url without query string
        $urlWithQueryString = $request->fullUrl(); // get url with query string
        $request->fullUrlWithQuery(['type' => 'phone']); // append in query string data

        $value = $request->header('X-Header-Name'); // get header
        $value = $request->header('X-Header-Name', 'default'); // get header and if not then default value
        $request->hasHeader('X-Header-Name'); // check header in request

        $token = $request->bearerToken(); //retrieve a bearer token from the Authorization header
        $ipAddress = $request->ip(); // IP address of the client that made the request to your application

        $contentTypes = $request->getAcceptableContentTypes();
        if ($request->accepts(['text/html', 'application/json'])) {
        }
        $preferred = $request->prefers(['text/html', 'application/json']);
        if ($request->expectsJson()) {
        }

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

        if ($request->has('name')) {
        }
        if ($request->has(['name', 'email'])) {
        }
        $request->whenHas('name', function ($input) {
        });

        $request->whenHas('name', function ($input) { /* if */
        }, function () { /* else */
        });

        if ($request->hasAny(['name', 'email'])) {
        }
        if ($request->filled('name')) {
        }
        $request->whenFilled('name', function ($input) {
        });
        $request->whenFilled('name', function ($input) {
        }, function () {
        });
        if ($request->missing('name')) {
        }
        $request->mergeIfMissing(['votes' => 0]);
        $request->flash();
        $request->flashOnly(['username', 'email']);
        $request->flashExcept('password');

        return redirect('form')->withInput();
        return redirect()->route('user.create')->withInput();
        return redirect('form')->withInput($request->except('password'));
        // <input type="text" name="username" value="{{ old('username') }}">
        $username = $request->old('username');
        $value = $request->cookie('name');

        // retrieving uploaded file
        $file = $request->file('photo');
        $file = $request->photo;
        if ($request->hasFile('photo')) {
        }
        if ($request->file('photo')->isValid()) {
        }
        $path = $request->photo->path();
        $extension = $request->photo->extension();
    }

    public function test_response(Request $request)
    {
        return response('Hello World', 200)
            ->header('Content-Type', 'text/plain')
            ->header('X-Header-One', 'Header Value');

        return response('Hello World', 200)
            ->withHeaders(
                ['Content-Type' => 'text/plain'],
                ['X-Header-One' => 'Header Value']
            );

        return response('Hello World')->cookie('name','value',$minutes,$path,$domain,$secure,$httpOnly);

        return response('Hello World')->withoutCookie('name');

        return redirect('home/dashboard'); // redirect on url
        return back()->withInput(); // redirect back with input data
        return redirect()->route('login'); // redirect on named routes
        return redirect()->route('profile', ['id' => 1]); // redirect on named routes
        return redirect()->route('profile', [@$user]); // where $user is user object where it find if automatically
        return redirect()->action([UserController::class, 'index']); // Redirecting To Controller Actions
        // If your controller route requires parameters, you may pass them as the second argument to the action method
        return redirect()->action(
            [UserController::class, 'profile'],
            ['id' => 1]
        );
        return redirect()->away('https://www.google.com'); //Redirecting To External Domains
        return redirect('dashboard')->with('status', 'Profile updated!'); // flash session
        // @if (session('status')) {{ session('status') }} @endif // retreive with this

        return response()
            ->view('hello', $data, 200)
            ->header('Content-Type', $type);

        return response()
            ->json(['name' => 'Abigail', 'state' => 'CA'])
            ->withCallback($request->input('callback'));

        return response()->download($pathToFile); // download file
        return response()->download($pathToFile, $name, $headers); // with name and header
        return response()->caps('foo'); // check macro function in AppServiceProvider
    }

    public function test_view(Request $request)
    {
        return view('test_composer');
        return view('test', ['data'=>'data']);
        return view('test', compact('data'));
        return View::make('greeting', ['name' => 'James']);
        return View::first(['custom.admin', 'admin'], $data);
        if (View::exists('emails.customer')) {
            //
        }
    }

    public function test_blade(Request $request)
    {
        return view('test_blade', ['name'=> 'John','users'=>['ABCD','XYZ','PQR']]);
    }

    public function test_url_generation(Request $request)
    {
        // echo  url("/posts/{$post->id}");
        echo URL::current(); echo "<br/>";
        
        // Get the current URL without the query string...
        echo url()->current(); echo "<br/>";

        // Get the current URL including the query string...
        echo url()->full(); echo "<br/>";

        // Get the full URL for the previous request...
        echo url()->previous(); echo "<br/>";
    }

    public function test_session(Request $request)
    {
        $value = $request->session()->get('key');
        $value = $request->session()->get('key', 'default');

        $value = $request->session()->get('key', function () {
            return 'default';
        });

        // Global session
        $value = session('key');
        // Specifying a default value...
        $value = session('key', 'default');
        // Store a piece of data in the session...
        session(['key' => 'value']);
        
        // Retrieving All Session Data
        $data = $request->session()->all();

        // To determine if an item is present in the session, you may use the has method. The has method returns true if the item is present and is not null:
        if ($request->session()->has('users')) {
        }

        // To determine if an item is present in the session, even if its value is null, you may use the exists method:
        if ($request->session()->exists('users')) {
        }

        // To determine if an item is not present in the session, you may use the missing method. The missing method returns true if the item is null or if the item is not present:
        if ($request->session()->missing('users')) {
        }

        // Via a request instance...
        $request->session()->put('key', 'value');

        // Via the global "session" helper...
        session(['key' => 'value']);


        // The push method may be used to push a new value onto a session value that is an array.
        $request->session()->push('user.teams', 'developers');

        // The pull method will retrieve and delete an item from the session in a single statement:
        $value = $request->session()->pull('key', 'default');

        // If your session data contains an integer you wish to increment or decrement, you may use the increment and decrement methods:
        $request->session()->increment('count');
        $request->session()->increment('count', $incrementBy = 2);
        $request->session()->decrement('count');
        $request->session()->decrement('count', $decrementBy = 2);

        // Sometimes you may wish to store items in the session for the next request
        $request->session()->flash('status', 'Task was successful!');

        // If you need to persist your flash data for several requests, you may use the reflash method, which will keep all of the flash data for an additional request. If you only need to keep specific flash data, you may use the keep method:
        $request->session()->reflash();
        $request->session()->keep(['username', 'email']);
        
        // To persist your flash data only for the current request, you may use the now method:
        $request->session()->now('status', 'Task was successful!');

        // Forget a single key...
        $request->session()->forget('name');

        // Forget multiple keys...
        $request->session()->forget(['name', 'status']);

        //entire session of the project
        $request->session()->flush();

        $request->session()->invalidate();
    }

}
