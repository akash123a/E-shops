<h2>Manage Navbar</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

    <style>
#menu-list {
    list-style: none;
    padding: 0;
    max-width: 400px;
}

.menu-item {
    padding: 10px;
    margin-bottom: 5px;
    background: #f5f5f5;
    border: 1px solid #ddd;
    cursor: move;
    border-radius: 5px;
}
        </style>

<form method="POST" action="{{ route('navbar.store') }}">
    @csrf

    <select name="page_id">
    <option value="">-- Select Page --</option>
    @foreach(\App\Models\Page::all() as $page)
        <option value="{{ $page->id }}">{{ $page->title }}</option>
    @endforeach
</select>


    <input type="text" name="title" placeholder="Menu Name" required>
    <input type="text" name="url" placeholder="/about">

    <input type="number" name="order" placeholder="Order">

    {{-- Parent Dropdown --}}
    <select name="parent_id">
        <option value="">-- Main Menu --</option>
        @foreach($parents as $parent)
            <option value="{{ $parent->id }}">{{ $parent->title }}</option>
        @endforeach
    </select>

    <select name="status">
        <option value="1">Show</option>
        <option value="0">Hide</option>
    </select>

    <button type="submit">Add Menu</button>
</form>



<ul id="menu-list">
    @foreach($navbars->sortBy('order') as $menu)
        <li class="menu-item" data-id="{{ $menu->id }}">
            ☰ {{ $menu->title }}
        </li>
    @endforeach
</ul>

<hr>

<table border="1" cellpadding="10">
    <tr>
        <th>Title</th>
        <th>URL</th>
        <th>Order</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($navbars as $nav)
        <tr>
            <td>{{ $nav->title }}</td>
            <td>{{ $nav->url }}</td>
            <td>{{ $nav->order }}</td>
            <td>{{ $nav->status ? 'Show' : 'Hide' }}</td>
            <td>
                <a href="{{ route('navbar.edit', $nav->id) }}">Edit</a> |
                <a href="{{ route('navbar.delete', $nav->id) }}" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
    @endforeach
</table>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<!-- <script>
$(function () {
    $("#menu-list").sortable({
        update: function (event, ui) {

            let order = [];

            $(".menu-item").each(function () {
                order.push($(this).data("id"));
            });

            $.ajax({
                url: "{{ route('navbar.reorder') }}",
                method: "POST",
                data: {
                    order: order,
                    _token: "{{ csrf_token() }}"
                },
                success: function (res) {
                    console.log("Order updated");
                }
            });
        }
    });
});
</script> -->

<script>
document.addEventListener("DOMContentLoaded", function () {

    let el = document.getElementById('menu-list');

    new Sortable(el, {
        animation: 150,

        onEnd: function () {
            let order = [];

            document.querySelectorAll('.menu-item').forEach((item) => {
                order.push(item.dataset.id);
            });

            fetch("{{ route('navbar.reorder') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ order: order })
            })
            .then(res => res.json())
            .then(data => {
                console.log("Order saved");
            });
        }
    });

});
</script>