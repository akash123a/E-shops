@extends('admin.layout')

@section('content')

<h2>Pages</h2>

<a href="{{ route('pages.create') }}">+ Add Page</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>Title</th>
        <th>Slug</th>
        <th>Action</th>
    </tr>

    @foreach($pages as $page)
        <tr>
            <td>{{ $page->title }}</td>
            <td>{{ $page->slug }}</td>
            <td>
                <a href="{{ route('pages.edit', $page->id) }}">Edit</a> |
                <a href="{{ route('pages.delete', $page->id) }}" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
    @endforeach
</table>

@endsection