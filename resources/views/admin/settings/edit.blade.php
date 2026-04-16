@extends('admin.layout')

@section('content')

<h2>Edit Setting</h2>

<form method="POST" action="{{ route('settings.update', $setting->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Key</label><br>
    <input type="text" name="key" value="{{ $setting->key }}"><br><br>

    <label>Value</label><br>
    <input type="text" name="value" value="{{ $setting->value }}"><br><br>

    <label>Upload New File</label><br>
    <input type="file" name="file"><br><br>

    <button type="submit">Update</button>
</form>

@endsection