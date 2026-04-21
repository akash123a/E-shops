@extends('admin.layout')

@section('content')

<h2>Edit Menu</h2>

<form method="POST" action="{{ route('navbar.update', $navbar->id) }}">
    @csrf

    <input type="text" name="title" value="{{ $navbar->title }}">
    <input type="text" name="url" value="{{ $navbar->url }}">
    <input type="number" name="order" value="{{ $navbar->order }}">

    <select name="status">
        <option value="1" {{ $navbar->status ? 'selected' : '' }}>Show</option>
        <option value="0" {{ !$navbar->status ? 'selected' : '' }}>Hide</option>
    </select>

    <button type="submit">Update</button>
</form>


@endsection