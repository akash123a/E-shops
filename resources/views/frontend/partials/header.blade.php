
<ul class="navbar">
    <img src="{{ asset('uploads/settings/' . setting('logo')) }}" height="50">

@foreach($menus->whereNull('parent_id') as $menu)
    <li class="nav-item">

        @if($menu->children->count() > 0)
              <a href="{{ route('page.show', $menu->page->slug ?? 1) }}">
                {{ $menu->title }}
            </a>

            <ul class="dropdown">
                @foreach($menu->children as $child)
                    <li>
                        <a href="{{ route('page.show', $child->page->slug ?? 1) }}">
                            {{ $child->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <a href="{{ route('page.show', $menu->page->slug ?? 1) }}">
                {{ $menu->title }}
            </a>
        @endif

    </li>
@endforeach

</ul>
