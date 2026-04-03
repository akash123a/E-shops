@extends('admin.layout')

@section('content')
<h2>All Users</h2>

@foreach($users as $user)
    <p>{{ $user->name }} - {{ $user->email }}</p>
@endforeach
@endsection