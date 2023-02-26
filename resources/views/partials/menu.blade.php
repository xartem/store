<nav class="2xl:flex gap-8">
    @foreach($menu as $item)
        <a href="{{ $item->link() }}" class="text-white hover:text-pink {{ $item->isActive() ? 'font-bold' : '' }}">{{ $item->label() }}</a>
    @endforeach
</nav>