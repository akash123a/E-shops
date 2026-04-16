@extends('admin.layout')

@section('content')

<h2>Add Setting</h2>

<form method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data">
    @csrf

    <label>Key</label><br>
    <input type="text" name="key"><br><br>

    <label>Value</label><br>
    <input type="text" name="value"><br><br>

    <label>OR Upload File</label><br>
    <input type="file" name="file"><br><br>

    <button type="submit">Save</button>
</form>

@endsection