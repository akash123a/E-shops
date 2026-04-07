<h2>Your Groups</h2>

<form method="POST" action="/groups">
    @csrf
    <input type="text" name="name" placeholder="Group Name">
    <button>Create</button>
</form>

@foreach($groups as $group)
    <p>
        {{ $group->name }}
        <a href="/balance/{{ $group->id }}">View Balance</a>
    </p>
@endforeach