
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
   <button onclick="toggleDarkMode()" id="darkToggle">
    🌙 Dark Mode
</button>
</ul>


<script>

    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.body.classList.add("dark");
}

function toggleDarkMode() {
    document.body.classList.toggle("dark");

    let btn = document.getElementById("darkToggle");

    if (document.body.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
        btn.innerText = "☀️ Light Mode";
    } else {
        localStorage.setItem("theme", "light");
        btn.innerText = "🌙 Dark Mode";
    }
}

// Load saved theme
window.onload = function() {
    let theme = localStorage.getItem("theme");
    if (theme === "dark") {
        document.body.classList.add("dark");
    }
};
</script>