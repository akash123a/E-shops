@extends('admin.layout')

@section('content')

<h2>Settings</h2>

<a href="{{ route('settings.create') }}">+ Add Setting</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Key</th>
        <th>Value</th>
        <th>Action</th>
    </tr>

    @foreach($settings as $setting)
        <tr>
            <td>{{ $setting->id }}</td>
            <td>{{ $setting->key }}</td>
            <td>
                @if(Str::contains($setting->value, ['.png','.jpg','.jpeg']))
                    <img src="{{ asset('uploads/settings/'.$setting->value) }}" height="40">
                @else
                    {{ $setting->value }}
                @endif
            </td>
            <td>
                <a href="{{ route('settings.edit', $setting->id) }}">Edit</a>

                <form action="{{ route('settings.delete', $setting->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Delete?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

@endsection