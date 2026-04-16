@extends('admin.layout')
@section('content')

<h2>All Sliders</h2>

<a href="{{ route('sliders.create') }}">Add Slider</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Image</th>
        <th>Action</th>
    </tr>

    @foreach($sliders as $slider)
    <tr>
        <td>{{ $slider->id }}</td>
        <td>{{ $slider->title }}</td>
        <td>
            <img src="{{ asset('uploads/sliders/'.$slider->image) }}" width="100">
        </td>
        <td>
            <a href="{{ route('sliders.edit', $slider->id) }}">Edit</a>

            <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>


@endsection