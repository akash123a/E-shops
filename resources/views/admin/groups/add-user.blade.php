@extends('admin.layout')

@section('content')

<h2>Add User to {{ $group->name }}</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if($errors->any())
    <div style="color:red;">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('group.addUser') }}">
    @csrf

    {{-- Hidden Group ID --}}
    <input type="hidden" name="group_id" value="{{ $group->id }}">

    {{-- User Name Input --}}
    <label>Enter User Name:</label><br><br>
    <input type="text" name="user_name" placeholder="Enter name or email" required>

    <br><br>
    <button type="submit">Add User</button>
</form>

<br>
<a href="{{ route('admin.dashboard') }}">⬅ Back to Dashboard</a>

@endsection