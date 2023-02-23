@if($flash = flash()->get())
    <div class="{{ $flash->class() }}">{{ $flash->message() }}</div>
@endif

@if(session()->has('message'))
    {{ session('message') }}
@endif