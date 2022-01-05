<h3>Test View file<h3>
    
<x-test-component passData="Hello World...!!!" />

@if($errors->any())
    @foreach($errors->all() as $error)
        {{$error}}
    @endforeach
@endif

@error('userName')
    {{$message}}
@enderror

<script>
    var users = @json($users);
    console.log(users);
</script>

<form action="/example" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>
<form action="/example" method="POST">
    @method('PUT')
    @csrf
</form>