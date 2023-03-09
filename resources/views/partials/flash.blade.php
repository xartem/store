@if($flash = flash()->get())
    <div class="container rounded-2xl p-4 mt-5 {{ $flash->class() }}">{{ $flash->message() }}</div>
@endif

@if(session()->has('message'))
    {{ session('message') }}
@endif