@extends('admin.layouts.app')

@section('content')

<h2>Your Groups</h2>

<form method="POST" action="/group">
    @csrf
    <input type="text" name="name" placeholder="New Group Name" required>
    <button class="btn btn-primary">Create</button>
</form>

<hr>

@foreach($groups as $group)
    <div class="card p-3 mb-2">
        <h5>{{ $group->name }}</h5>

        <a href="/balance/{{ $group->id }}" class="btn btn-success">
            View Balance
        </a>
    </div>
@endforeach

@endsection