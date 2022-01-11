<h3>Test View file</h3>
<span>Hello, {{ $name }}</span><br/>
<span>Hello, {!! $name !!}.</span><br/> {{-- to prevent XSS attacks. If you do not want your data to be escaped, you may use --}}
<span>The current UNIX timestamp is {{ time() }}.</span><br/>

{{-- ignore doble braces syntax of blade template --}}
<span>Hello, @{{ $name }}.</span><br/>
{{-- same as above but for block of html code --}}
@verbatim
    <span>Hello, {{ $name }}.</span>
@endverbatim

<script>
    var js_user = '{{ $name }}';
    var users = @json($users);
    var users1 = '<?php echo json_encode($users); ?>';
    users1 = JSON.parse(users1);
    var users2 = {{ Illuminate\Support\Js::from($users) }};
    console.log(users);
    console.log(users1);
    console.log(users2);
</script>

@if (count($name) === 1)
    I have one record!
@elseif (count($name) > 1)
    I have multiple records!
@else
    I don't have any records!
@endif

@unless (Auth::check())
    You are not signed in.
@endunless

@isset($records)
    // $records is defined and is not null...
@endisset

@empty($records)
    // $records is "empty"...
@endempty

@auth
    // The user is authenticated...
@endauth

@guest
    // The user is not authenticated...
@endguest

@production
    // Production specific content...
@endproduction

@env('staging')
    // The application is running in "staging"...
@endenv

@env(['staging', 'production'])
    // The application is running in "staging" or "production"...
@endenv

@hasSection('navigation')
    <div class="pull-right">
        @yield('navigation')
    </div>

    <div class="clearfix"></div>
@endif

@sectionMissing('navigation')
    <div class="pull-right">
        @include('default-navigation')
    </div>
@endif

@switch($i)
    @case(1)
        First case...
        @break

    @case(2)
        Second case...
        @break

    @default
        Default case...
@endswitch

@for ($i = 0; $i < 10; $i++)
    The current value is {{ $i }}
@endfor

@foreach ($users as $user)
    <p>This is user {{ $user->id }}</p>
@endforeach

@forelse ($users as $user)
    <li>{{ $user->name }}</li>
@empty
    <p>No users</p>
@endforelse

@while (true)
    <p>I'm looping forever.</p>
@endwhile


@foreach ($users as $user)
    @if ($user->type == 1)
        @continue
    @endif

    <li>{{ $user->name }}</li>

    @if ($user->number == 5)
        @break
    @endif
@endforeach

@foreach ($users as $user)
    @continue($user->type == 1)

    <li>{{ $user->name }}</li>

    @break($user->number == 5)
@endforeach


@foreach ($users as $user)
    @if ($loop->first)
        This is the first iteration.
    @endif

    @if ($loop->last)
        This is the last iteration.
    @endif

    <p>This is user {{ $user->id }}</p>

    $loop->index  {{-- 	The index of the current loop iteration (starts at 0) --}}.
    $loop->iteration  {{-- 	The current loop iteration (starts at 1) --}}.
    $loop->remaining  {{-- 	The iterations remaining in the loop --}}.
    $loop->count  {{-- 	The total number of items in the array being iterated --}}.
    $loop->first  {{-- 	Whether this is the first iteration through the loop --}}.
    $loop->last  {{-- 	Whether this is the last iteration through the loop --}}.
    $loop->even  {{-- 	Whether this is an even iteration through the loop --}}.
    $loop->odd  {{-- 	Whether this is an odd iteration through the loop --}}.
    $loop->depth  {{-- 	The nesting level of the current loop --}}.
    $loop->parent  {{-- 	When in a nested loop, the parent's loop variable --}}.
@endforeach

{{-- Dynamic Class --}}
@php
    $isActive = false;
    $hasError = true;
@endphp
<span @class([
    'p-4',
    'font-bold' => $isActive,
    'text-gray-500' => ! $isActive,
    'bg-red' => $hasError,
])></span>

{{-- Including Subviews --}}
 @include('shared.errors') {{-- include view --}}
 @include('view.name', ['status' => 'complete']) {{-- pass data to view --}}
 @includeIf('view.name', ['status' => 'complete']) {{-- if we have view of view.name --}} 
 @includeWhen($boolean, 'view.name', ['status' => 'complete']) {{-- include if we have condition true --}}
 @includeUnless($boolean, 'view.name', ['status' => 'complete']) {{-- include if we have condition true --}}
 @includeFirst(['custom.admin', 'admin'], ['status' => 'complete']) {{-- if we have to view in option then we can set priority --}}
 
 @each('view.name', $jobs, 'job') {{-- Rendering Views For Collections --}}
 @each('view.name', $jobs, 'job', 'view.empty')

{{-- if you are rendering a given component within a loop, you may wish to only push the JavaScript to the header the first time --}}
 @once
    @push('scripts')
        <script>
            // Your custom JavaScript...
        </script>
    @endpush
@endonce

@php
    $counter = 1;
@endphp

{{-- Components --}}
<x-test-component passData="Hello World...!!!" />

{{-- <x-button ::class="{ danger: isDeleting }">
    Submit
</x-button> --}}






@if($errors->any())
    @foreach($errors->all() as $error)
        {{$error}}
    @endforeach
@endif
@error('userName')
    {{$message}}
@enderror
<form action="/example" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>
<form action="/example" method="POST">
    @method('PUT')
    @csrf
</form>