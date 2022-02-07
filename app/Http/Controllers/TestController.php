<?php

namespace App\Http\Controllers;

use App\Models\BLog;
use App\Models\Brand;
use App\Models\Product;
use App\Events\BrandCreated;
use App\Jobs\BrandJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;

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
        // php artisan make:controller ProvisionServer --invokable
        info('this is for singleton action controller');
    }

    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('log')->only('index');
        // $this->middleware('subscribed')->except('store');
    }

    public function index(Request $request)
    {
        return ['index function'];
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

    public function test_eloquent(Request $request)
    {
        // php artisan make:model Brand >>> Create normal eloquent
        // php artisan make:model Brand --migration >>> Create normal eloquent

        // same as --migration we can use below things to
        // '--factory' OR '-f' >>> Model and a BrandFactory class
        // '--seed' OR '-s' >>> Model and a BrandSeeder class
        // '--controller' OR '-c' >>> Model and a BrandController class
        // '--factory' OR '-f' >>> Model and a BrandFactory class
        // '--factory' OR '-f' >>> Model and a BrandFactory class
        // '--controller --resource --requests' OR '-crR' >>> resource controller and request class
        // '--policy' >>> Model and a BrandPolicy class
        // '-mfsc' >>> migration, factory, seeder, and controller
        // '--all' >>> model, migration, factory, seeder, policy, controller, and form requests
        // '--pivot' >>> pivot model


        // return Brand::all(); // retrieving model data
        // foreach (Brand::all() as $brand) {
        //     echo $brand->name."<br/>";
        // }

        // return Brand::where('status', 'Active')
        // ->orderBy('name')
        // ->take(10)
        // ->get();


        // $brand = Brand::where('name', 'FR 900')->first();
        // If you already have an instance of an Eloquent model that was retrieved from the database, you can "refresh" the model using the fresh and refresh methods
        // $freshBrand = $brand->fresh();
        // $brand = Brand::where('name', 'FR 900')->first();
        // $brand->name = 'FR 456';
        // $brand->refresh();
        // $brand->name; // "FR 900"


        // Brand::chunk(100, function ($brands) {
        //     foreach ($brands as $brand) {
        //         echo $brand->name."<br/>";
        //     }
        // });


        // Brand::/* where('status', 'Active')-> */chunkById(200, function ($brands) {
        //     $brands->each->update(['status' => 'aaa']);
        // },'id'); // dont knw use of third argument


        // $brands = Brand::get();
        // $brands = $brands->reject(function ($brand) {
        //     return $brand->custom_primary_id; // consider those record who have value null or empty in define column with reject method.
        // });


        // lazy work same as chunk behind the scene
        // foreach (Brand::lazy() as $brand) {
        //     echo $brand->name."<br/>";
        // }

        // Brand::where('status', 'aaa')
        //     ->lazyById(200, $column = 'id')
        //     ->each->update(['details' => 'test detail']);

        //same as lazy bt it only helps with the single eloquent for eager load relation use lazy.
        // foreach (Brand::cursor() as $brand) {
        //     echo $brand->name . "<br/>";
        // }


        // $brand = Brand::addSelect([
        //     'product' => Product::select('name')->limit(1)
        // ])->get();


        // $brand = Brand::find(1);
        // $brand = Brand::where('status', 1)->first(); // retreive first element occures
        // $brand = Brand::firstWhere('status', 1); // same as above in short form

        // $brand = Brand::where('id', 1)->firstOr(function () {
        //     // execute this part if not found
        // });

        // $brand = Brand::findOrFail(1); // 404 HTTP response is automatically if fail
        // $brand = Brand::where('status', '=', 3)->firstOrFail();

        // Retrieve brand by name or create it if it doesn't exist...
        // $brand = Brand::firstOrCreate([
        //     'name' => 'new branddd'
        // ]);

        // Retrieve brand by name or create it with the name, logo, and details attributes...
        // $brand = Brand::firstOrCreate(
        //                                 ['name' => 'Nike aaa', 'status' => 'Active'],
        //                                 ['logo' => 1, 'details' => 'asasa asas']
        //                             );

        // first arg match data
        // second arg insert data along with data which we passed to use
        // $brand = Brand::updateOrCreate(
        //                                 ['name' => 'Nike aaa', 'status' => 'Active'],
        //                                 ['logo' => 1, 'details' => 'asasa asas']
        //                             );

        // first args = data to update or create
        // second args = names of column which will match with data
        // third args = columns that should be updated if a matching record already exists
        // Brand::upsert([
        //     ['name' => 'Oakland', 'logo' => 'San Diego', 'status' => 99],
        //     ['name' => 'Chicago', 'logo' => 'New York', 'status' => 150]
        // ], ['name', 'logo'], ['status']);

        // Retrieve brand by name or instantiate a new Brand instance...
        // $brand = Brand::firstOrNew([
        //     'name' => 'London to Paris'
        // ]);
        // Retrieve brand by name or instantiate with the name, logo, and details attributes...
        // $brand = Brand::firstOrNew(['name' => 'Nike aaa'], ['logo' => 1, 'details' => 'asasa asas']);

        // $count = Brand::where('status', 'Active')->count();
        // $max = Brand::where('status', 'Active')->max('id');

        // create record method 1
        // $save_brand = Brand::create([
        //     'name'=>'aaa',
        //     'logo' => 'aaa',
        //     'details' => 'aaa',
        // ]);

        // create record method 2
        // $brandObj = new Brand;
        // $brandObj->name = 'bbb';
        // $brandObj->logo = 'bbb';
        // $brandObj->details = 'bbb';
        // $brandObj->save();

        // update record method 1
        // $save_brand = Brand::where('id',1)->update([
        //     'name'=>'aaa',
        //     'logo' => 'aaa',
        //     'details' => 'aaa',
        // ]);

        // update record method 2
        // $brandObj = Brand::find(1);
        // $brandObj->name = 'bbb';
        // $brandObj->logo = 'bbb';
        // $brandObj->details = 'bbb';
        // $brandObj->save();

        // $brand = Brand::find(1);
        // $brand->delete(); // delete specific record
        // Brand::truncate(); // truncate all table data

        // Brand::destroy(1);
        // Brand::destroy(1, 2, 3);
        // Brand::destroy([1, 2, 3]);
        // Brand::destroy(collect([1, 2, 3]));

        // $deleted = Brand::where('active', 0)->delete(); // delete model with query


        /* isDirty isClean - Eloquent Attribute Changes */
        // $brand = User::create([
        //     'name' => 'Taylor',
        //     'logo' => 'Otwell',
        //     'details' => 'Developer',
        // ]);

        // $brand->name = 'Painter';

        // $brand->isDirty(); // true
        // $brand->isDirty('name'); // true
        // $brand->isDirty('logo'); // false

        // $brand->isClean(); // false
        // $brand->isClean('name'); // false
        // $brand->isClean('logo'); // true

        // $brand->save();

        // $brand->wasChanged(); // true
        // $brand->wasChanged('name'); // true
        // $brand->wasChanged('logo'); // false

        // $brand->isDirty(); // false
        // $brand->isClean(); // true


        // $brand = Brand::find(1);

        // $brand->name; // John
        // $brand->logo; // new logo

        // $brand->name = "Jack";
        // $brand->name; // Jack

        // $brand->getOriginal('name'); // John
        // $brand->getOriginal(); // Array of original attributes...

        /* Softdelete */

        // $flight->forceDelete(); // delete permenant delete
        
        // if ($brand->trashed()) {
        //     // check model instance has been soft delete
        // }

        // $flight->restore(); // set the model's deleted_at column to null

        // find softdeleted record and restore it with setting deleted_at value to null
        // Brand::withTrashed()
        // ->where('name', 'aaa')
        // ->restore();

        // withTrashed() // get trashed record along with normal record
        // onlyTrashed() // get only trashed record

        // Pruning Models --- THIS IS REMAINING

        // Comparing Models
        // if ($brand->is($anotherBrand)) {
        // }
        // if ($brand->isNot($anotherBrand)) {
        // }
        // if ($brand->author()->is($user)) {
        // }

        
        // "mute" all events fired by a model.
        // $brand = Brand::withoutEvents(function () use () {
        //     Brand::findOrFail(1)->delete();
        //     return Brand::find(2);
        // });

        // "mute" events with save() method.
        // $brand = Brand::findOrFail(1);
        // $brand->name = 'Victoria Faith';
        // $brand->saveQuietly();
    }

    public function test_pagination(Request $request)
    {
        // return view('user.index', [
        //     'brands' => DB::table('brands')->paginate(15)
        // ]);

        // $brands = DB::table('brands')->simplePaginate(15); // only need to display simple "Next" and "Previous" links

        // $brands = Brand::paginate(15);
        // $brands = Brand::simplePaginate(15);

        // $brands = DB::table('brands')->orderBy('id')->cursorPaginate(15);

        // $brands = Brand::paginate(15);
        // $brands->withPath('/admin/brands');

        // $brands = Brand::paginate(15);
        // $brands->appends(['sort' => 'votes']);

        // $brands = Brand::paginate(15)->withQueryString(); //  append all of the current request's query string values to the pagination links

        // $brands = Brand::paginate(15)->fragment('brands');

        // return User::paginate(); // convert to json

        // {{ $brands->links() }} // display pagination link
    }

    public function test_file_upload(Request $request)
    {
        // $path = $request->file('avatar')->store('avatars');
        // $path = Storage::putFile('avatars', $request->file('avatar'));

        // store method will use your default disk. If you would like to specify another disk, pass the disk name as the second argument to the store method
        // $path = $request->file('avatar')->store(
        //     'avatars/' . $request->user()->id,
        //     's3'
        // );

        // $path = $request->file('avatar')->storeAs(
        //     'avatars',
        //     $request->user()->id,
        //     's3'
        // );

        // $file = $request->file('avatar');
        // $name = $file->getClientOriginalName();
        // $extension = $file->getClientOriginalExtension();

        // $file = $request->file('avatar');
        // $name = $file->getClientOriginalName(); // Generate a unique, random name...
        // $extension = $file->getClientOriginalExtension(); // Determine the file's extension based on the file's MIME type...

        // Storage::put('file.jpg', $contents, 'public'); //public or private. set visiblity

        // $visibility = Storage::getVisibility('file.jpg');
        // Storage::setVisibility('file.jpg', 'public');

    }

    public function test_eloquent_relationship(Request $request)
    {
        // $brand = Brand::find(1)->has_one_product;
        // $product = Product::find(1)->has_one_brand;

        // $brand = Brand::where('id',1)->with('has_one_product')->get();
        // $product = Product::where('id', 1)->with('has_one_brand')->get();

        // $brand = Brand::where('id', 1)->with('belongs_to_product')->first();
        // print_r(@$brand->belongs_to_product->name);

        // $brand = Brand::find(1)->has_many_product;
        // $brand = Brand::where('id', 1)->with('has_many_product')->get();


        echo "<pre>";
        // print_r(@$brand->toArray());
        // print_r(@$product->toArray());
        exit();
    }

    public function test_eloquent_query_scope(Request $request){
        // $brands = Brand::active()->get();
        // $users = Brand::popular()->orWhere(function (Builder $query) {
        //     $query->active();
        // })->get();
    }

    public function test_eloquent_collections(Request $request)
    {
        // $brands = Brand::get()->reject(function($brand){
        //     return $brand->status == 'aaa'; 
        // })->toArray();

        // $brands = Brand::get()->map(function ($brand) {
        //     return $brand->name;
        // })->toArray();

        // combine above these two methods
        // $brands = Brand::all()->reject(function ($brand) {
        //     return $brand->active === false;
        // })->map(function ($brand) {
        //     return $brand->name;
        // });

        // $users->contains(User::find(1));

        // $brands = Brand::find(1);
        // $brands = $brands->diff(Brand::whereIn('id', [1, 2, 3])->get());
        // $brands = $brands->except([1, 2, 3]);
        // $user = $brands->find(1);

        // $brands = $brands->fresh();
        // $brands = $brands->fresh('comments');

        // $brands->loadMissing(['comments', 'posts']);
        // $brands->loadMissing('comments.author');
        // $brands->modelKeys();

        // $brands = $brands->makeVisible(['address', 'phone_number']);
        // $brands = $brands->makeHidden(['address', 'phone_number']);
        // $brands = $brands->only([1, 2, 3]);

        // $brands->toQuery()->update([
        //     'status' => 'Administrator',
        // ]);
        // $brands->toQuery()->update([
        //     'status' => 'Administrator',
        // ]);
    }

    public function test_general_laravel_collections(Request $request){
        // $collection = collect([1, 2, 3]);

        // Collection::macro('toUpper', function ($args = '') {
        //     return $this->map(function ($value) use($args) {
        //             // $args we can use
        //             return Str::upper($value);
        //         });
        // });
        // $collection = collect(['first', 'second']);
        // $upper = $collection->toUpper(); // ['FIRST', 'SECOND']
        // $upper = $collection->toUpper('aaaa'); // with arguments
    }

    public function test_authorization(Request $request, Brand $brand)
    {
        // if(!Gate::allows('update-brand-with-gate', $brand)) {
        //     abort(403);
        // }
        // if (Gate::forUser($user)->allows('update-post', $post)) {
        //     // The user can update the post...
        // }
        // if (Gate::forUser($user)->denies('update-post', $post)) {
        //     // The user can't update the post...
        // }
        // if (Gate::any(['update-post', 'delete-post'], $post)) {
        //     // The user can update or delete the post...
        // }
        // if (Gate::none(['update-post', 'delete-post'], $post)) {
        //     // The user can't update or delete the post...
        // }
    }

    public function test_email_verification(Request $request, Brand $brand)
    {
        /* use below for manual user registration */
        // use Illuminate\Auth\Events\Registered;
        // event(new Registered($user));

        // first link send page
        // Route::get('/email/verify', function () {
        //     return view('auth.verify-email');
        // })->middleware('auth')->name('verification.notice');

        // second link to verify email
        // Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        //     $request->fulfill();

        //     return redirect('/home');
        // })->middleware(['auth', 'signed'])->name('verification.verify');

        //third link to resend send email
        // Route::post('/email/verification-notification', function (Request $request) {
        //     $request->user()->sendEmailVerificationNotification();
        //     return back()->with('message', 'Verification link sent!');
        // })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    }

    public function test_file_storage(Request $request)    
    {
        // Storage::disk('local')->put('example.txt', 'Contents');

        // php artisan storage:link
        // 'links' => [
        //     public_path('storage') => storage_path('app/public'),
        //     public_path('images') => storage_path('app/images'),
        // ],

        // Storage::put('avatars/1', $content);
        // Storage::disk('s3')->put('avatars/1', $content);

        // Retrieving Files
        // $contents = Storage::get('file.jpg');
        // if (Storage::disk('s3')->exists('file.jpg')) {
        // }
        // if (Storage::disk('s3')->missing('file.jpg')) {
        // }
        // file urls
        // $url = Storage::url('file.jpg');

        /* spatie/laravel-medialibrary */
        // $newsItem = News::find(1);
        // $newsItem->addMedia($pathToFile)->toMediaCollection('images');

        // uploads directly:
        // $newsItem->addMedia($request->file('image'))->toMediaCollection('images');

        // $newsItem->addMedia($smallFile)->toMediaCollection('downloads', 'local');
        // $newsItem->addMedia($bigFile)->toMediaCollection('downloads', 's3');

        /* Intervention/image */
        // open an image file
        // $img = \Image::make('public/foo.jpg');
        // // resize image instance
        // $img->resize(320, 240);
        // // insert a watermark
        // $img->insert('public/watermark.png');
        // // save image in desired format
        // $img->save('public/bar.jpg');
    }

    public function test_api(Request $request)
    {
        // return [1];

        // automatic error message with APP_DEBUG = false in laravel
        // $brand = Brand::findOrFail('aaaa'); // return automatically 404 with message 'Brand not found'
        
        // customize Exception message
        // $brand = Brand::find('aaa');
        // if(!$brand){
        //     abort(code:404, message: 'User not founddd....!!');
        // }

        // we can custom message in Exception Handler class in register() method as below
        // $this->renderable(function(NotFoundHttpException $e, $request){
        //     if($request->wantJson()){
        //         return response()->json(['message'=>'Object not found.', status: 404]);
        //     }   
        // });
    }

    public function test_logging(Request $request){
        // Log::emergency($message);
        // Log::alert($message);
        // Log::critical($message);
        // Log::error($message);
        // Log::warning($message);
        // Log::notice($message);
        // Log::info($message);
        // Log::debug($message);

        // Contextual Information
        // Log::info('User failed to login.', ['id' => $user->id]);
    }

    public function test_error_handling(Request $request)
    {
        // $this->reportable(function (InvalidOrderException $e) {
        // });
        // $this->reportable(function (InvalidOrderException $e) {
        // })->stop();
        // $this->reportable(function (InvalidOrderException $e) {
        //     return false;
        // });

        // rendering exception
        // $this->renderable(function (InvalidOrderException $e, $request) {
        //     return response()->view('errors.invalid-order', [], 500);
        // });

        // $this->renderable(function(NotFoundHttpException $e, $request){
        //     if($request->wantJson()){
        //         return response()->json(['message'=>'Object not found.', status: 404]);
        //     }   
                // if ($request->is('api/*')) {
                //     return response()->json([
                //         'message' => 'Record not found.'
                //     ], 404);
                // }
        // });

        // try {
        //     $user = (new UserSerive())->findByUsername($username);
        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
        //     return view('users.notfound', ['error'=>$exception->getMessage()]);
        // }

            
        // Custom HTTP Error Pages
        // resources/views/errors/404.blade.php
        // <h2>{{ $exception->getMessage() }}</h2> 
        // php artisan vendor:publish --tag=laravel-errors
    }

    public function test_notification(Request $request)
    {
        // use Notifiable;

        // use App\Notifications\InvoicePaid;
        // $user->notify(new InvoicePaid($invoice));

        // use Illuminate\Support\Facades\Notification;
        // Notification::send($users, new InvoicePaid($invoice));
        // Notification::sendNow($developers, new DeploymentCompleted($deployment));

        // Need to learn more in that
    }

    public function test_testing(Request $request)
    {
        // php artisan make:test UserTest
        // php artisan make:test UserTest --unit //  to create a test within the tests/Unit directory
        // php artisan make:test UserTest --pest // ou may provide the --pest option to the make:test command:
        // php artisan make:test UserTest --unit --pest

        // class ExampleTest extends TestCase
        // {
        //     public function test_basic_test()
        //     {
        //         $this->assertTrue(true);
        //     }
        // }

        // runnning test
        // php artisan test
        // php artisan test --testsuite=Feature --stop-on-failure
    }

    public function test_database_tesing(Request $request)
    {
        // use Illuminate\Foundation\Testing\RefreshDatabase;
        // use RefreshDatabase;

        // public function test_basic_example(){
        //     $response = $this->get('/');
        // }
    }

    public function test_query_builder_raw_expression(Request $request)
    {
        // $users = DB::table('users')
        //     ->select(DB::raw('count(*) as user_count, status'))
        //     ->where('status', '<>', 1)
        //     ->groupBy('status')
        //     ->get();

        // $orders = DB::table('orders')
        //     ->selectRaw('price * ? as price_with_tax', [1.0825])
        //     ->get();

        // $orders = DB::table('orders')
        //     ->whereRaw('price > IF(state = "TX", ?, 100)', [200])
        //     ->get();

        // $orders = DB::table('orders')
        //     ->select('department', DB::raw('SUM(price) as total_sales'))
        //     ->groupBy('department')
        //     ->havingRaw('SUM(price) > ?', [2500])
        //     ->get();

        // $orders = DB::table('orders')
        //     ->select('city', 'state')
        //     ->groupByRaw('city, state')
        //     ->get();

        // $users = DB::table('users')
        // ->join('contacts', 'users.id', '=', 'contacts.user_id')
        // ->join('orders', 'users.id', '=', 'orders.user_id')
        // ->select('users.*', 'contacts.phone', 'orders.price')
        // ->get();

        // $users = DB::table('users')
        //     ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
        //     ->get();

        // $sizes = DB::table('sizes')
        // ->crossJoin('colors')
        // ->get();

        // $users = DB::table('users')
        //     ->whereNull('last_name')
        //     ->union($first)
        //     ->get();

        // ->where('votes', '=', 100)
        // ->where('votes', '>=', 100)
        // ->where('votes', '<>', 100)
        // ->where('name', 'like', 'T%')
        // ->where([['status', '=', '1'],['subscribed', '<>', '1']]);
        // ->orWhere('name', 'John')
        //  ->orWhere(function($query) {$query->where('name', 'Abigail')->where('votes', '>', 50);});
        // ->where('preferences->dining->meal', 'salad')
        //  ->whereJsonContains('options->languages', 'en')
        //  ->whereJsonContains('options->languages', ['en', 'de'])
        //   ->whereJsonLength('options->languages', 0)
        //  ->whereJsonLength('options->languages', '>', 1)
        // ->whereBetween('votes', [1, 100])
        //   ->whereNotBetween('votes', [1, 100])
        // ->whereIn('id', [1, 2, 3])
        // ->whereNotIn('id', [1, 2, 3])
        //  ->whereNull('updated_at')
        //  ->whereNotNull('updated_at')
        // ->whereDate('created_at', '2016-12-31')
        // ->whereMonth('created_at', '12')
        // ->whereDay('created_at', '31')
        // ->whereYear('created_at', '2016')
        // ->whereYear('created_at', '2016')
        //  ->whereColumn('first_name', 'last_name')
        //  ->whereColumn('updated_at', '>', 'created_at')
        // ->whereColumn([['first_name', '=', 'last_name'],['updated_at', '>', 'created_at']])
        //  ->whereExists(function ($query) {
        //        $query->select(DB::raw(1))
        //              ->from('orders')
        //              ->whereColumn('orders.user_id', 'users.id');
        //    })

        // $incomes = Income::where('amount', '<', function ($query) {
        //     $query->selectRaw('avg(i.amount)')->from('incomes as i');
        // })->get();

        // ->latest()
        // ->inRandomOrder()
        // ->reorder()
        // ->orderBy()
        // ->groupBy()
        // ->having('account_id', '>', 100)
        //  ->havingBetween('number_of_orders', [5, 15])
        // ->offset(10)
        // ->limit(5)
        // ->insert()
        // ->insertOrIgnore()
        // ->insertGetId()
        // ->upsert()
        // ->update()
        // ->updateOrInsert()
        // ->increment('votes');
        // ->decrement('votes');
        // ->increment('votes', 5);
        // ->decrement('votes', 5);
        // ->delete();
        // ->truncate();
        //  ->sharedLock()
        // ->lockForUpdate()
        // ->dd();
        // ->dump();
    }

    public function test_observer(Request $request)
    {
        // php artisan make:observer UserObserver --model=User
        // User::observe(UserObserver::class); // put this inside `boot` method of EventServiceProvider 

        // $save_brand = Brand::create([
        //     'name'=>'new',
        //     'logo' => 'new logo',
        //     'details' => 'new logo details',
        //     'details' => 'Active'
        // ]);
        // $brandObj = new Brand;
        // $brandObj->name = 'new';
        // $brandObj->logo =  'new logo';
        // $brandObj->details = 'new logo details';
        // $brandObj->details = 'Active';
        // $save_brand = $brandObj->save();

        // "mute" all events fired by a model.
        // $brand = Brand::withoutEvents(function () use () {
        //     Brand::findOrFail(1)->delete();
        //     return Brand::find(2);
        // });

        // "mute" events with save() method.
        // $brand = Brand::findOrFail(1);
        // $brand->name = 'Victoria Faith';
        // $brand->saveQuietly();
    }   

    public function test_event(Request $request)
    {
        Event::listen(function (BrandCreated $event) {
        });
    }

    public function test_http_client(Request $request)
    {
        // composer require guzzlehttp/guzzle

        // $response = Http::get('http://example.com');
        // $response->body() : string;
        // $response->json() : array|mixed;
        // $response->object() : object;
        // $response->collect() : Illuminate\Support\Collection;
        // $response->status() : int;
        // $response->ok() : bool;
        // $response->successful() : bool;
        // $response->failed() : bool;
        // $response->serverError() : bool;
        // $response->clientError() : bool;
        // $response->header($header) : string;
        // $response->headers() : array;

        // return Http::dd()->get('http://example.com');
        $response = Http::post('http://example.com/users',
            [
                'name' => 'Steve',
                'role' => 'Network Administrator',
            ]
        );

        // $response = Http::asForm()->post('http://example.com/users', [
        //     'name' => 'Sara',
        //     'role' => 'Privacy Consultant',
        // ]);

        // $response = Http::withBody(
        //     base64_encode($photo),
        //     'image/jpeg'
        // )->post('http://example.com/photo');

        // $response = Http::attach(
        //     'attachment',
        //     file_get_contents('photo.jpg'),
        //     'photo.jpg'
        // )->post('http://example.com/attachments');

        // $photo = fopen('photo.jpg', 'r');
        // $response = Http::attach(
        //     'attachment', $photo, 'photo.jpg'
        // )->post('http://example.com/attachments');

        // $response = Http::withHeaders([
        //     'X-First' => 'foo',
        //     'X-Second' => 'bar'
        // ])->post('http://example.com/users', [
        //     'name' => 'Taylor',
        // ]);

        // $response = Http::accept('application/json')->get('http://example.com/users');
        // $response = Http::acceptJson()->get('http://example.com/users');

        // $response = Http::withToken('token')->post(...);

        // $response = Http::timeout(3)->get(...);

        // $response = Http::retry(3, 100, function ($exception) {
        //     return $exception instanceof ConnectionException;
        // })->post(...);

        // // Determine if the status code is >= 200 and < 300...
        // $response->successful();
        // // Determine if the status code is >= 400...
        // $response->failed();
        // // Determine if the response has a 400 level status code...
        // $response->clientError();
        // // Determine if the response has a 500 level status code...
        // $response->serverError();
    }

    public function test_laravel_socialite(Request $request)
    {
        // for third party login

        // $githubUser = Socialite::driver('github')->user();

        // $user = User::where('github_id', $githubUser->id)->first();

        // if ($user) {
        //     $user->update([
        //         'github_token' => $githubUser->token,
        //         'github_refresh_token' => $githubUser->refreshToken,
        //     ]);
        // } else {
        //     $user = User::create([
        //         'name' => $githubUser->name,
        //         'email' => $githubUser->email,
        //         'github_id' => $githubUser->id,
        //         'github_token' => $githubUser->token,
        //         'github_refresh_token' => $githubUser->refreshToken,
        //     ]);
        // }

        // Auth::login($user);

        // return redirect('/dashboard');
    }

    public function test_artisan_command(Request $request)
    {   
        // php artisan make:command SendEmails

        // check App/Console/Commands/ and files
        // check App/Console/kernal.php // commands() function

        // Optional argument...
        // mail:send {user?}

        // Optional argument with default value...
        // mail:send {user=foo}

    }

    public function test_task_scheduling(Request $request)
    {
        // php artisan schedule:list

        // invokable object
        // $schedule->call(new DeleteRecentUsers)->daily();

        // check App/Console/kernal.php // commands() function

        // Scheduling Artisan Commands
        // $schedule->command('emails:send Taylor --force')->daily();
        // $schedule->command(SendEmailsCommand::class, ['Taylor', '--force'])->daily();
    }

    public function test_cashing(Request $request)
    {
        // php artisan cache:table

        // $value = Cache::get('key');
        // $value = Cache::get('key', 'default');

        // $value = Cache::get('key', function () {
        //     return DB::table(...)->get();
        // });


        // if (Cache::has('key')) {}

        // Cache::increment('key');
        // Cache::increment('key', $amount);
        // Cache::decrement('key');
        // Cache::decrement('key', $amount);


        // $value = Cache::remember('brands', $seconds, function () {
        //     return DB::table('brands')->get();
        // });

        // Cache::put('key', 'value', $seconds = 10);
        // Cache::put('key', 'value', now()->addMinutes(10));
        // Cache::forever('key', 'value');
        // Cache::forget('key');
        // Cache::flush();

        // $value = cache('key');
        // cache(['key' => 'value'], $seconds);
        // cache(['key' => 'value'], now()->addMinutes(10));
    }

    public function test_job(Request $request)
    {
        // php artisan make:job BrandJob

        BrandJob::dispatch(['aaa'=>'bbb']);

        // BrandJob::dispatchIf($accountActive, ['aaa'=>'bbb']);
        // BrandJob::dispatchUnless($accountSuspended, ['aaa'=>'bbb']);
        // BrandJob::dispatch(['aaa'=>'bbb'])->delay(now()->addMinutes(10));
        // BrandJob::dispatchSync(['aaa'=>'bbb']);
        // BrandJob::dispatch(['aaa'=>'bbb'])->afterCommit();
        // BrandJob::dispatch(['aaa'=>'bbb'])->beforeCommit();

        // dealing with failed job
        // php artisan queue:failed-table
        // php artisan migrate
    }

    public function test_laravel_passport(Request $requests)
    {

        // $response = Http::asForm()->post('http://localhost/laravel_latest/public/oauth/token', [
        //     'grant_type' => 'Laravel Password Grant Client',
        //     'client_id' => '2',
        //     'client_secret' => 'pHbwAW0G8an4CbqDyNEYU34o8N7XKAgQryVMkN1n',
        //     'username' => 'ravi@gmail.com',
        //     'password' => 'admin@123',
        //     'scope' => '',
        // ]);
        // return $response->json();

        // $response = Http::asForm()->post('http://localhost/laravel_latest/public/oauth/token', [
        //     'grant_type' => 'refresh_token',
        //     'refresh_token' => 'the-refresh-token',
        //     'client_id' => 'client-id',
        //     'client_secret' => 'client-secret',
        //     'scope' => '',
        // ]);
        // return $response->json();
    }

    public function test_scout(Request $request)
    {
        $blogs = Blog::where('price', '>', 100)->searchable();
        $orders = Blog::search('Star Trek')->get();
    }
}
