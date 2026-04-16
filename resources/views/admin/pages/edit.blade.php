@extends('admin.layout')

@section('content')

<h2>Edit Page</h2>

<form method="POST" action="{{ route('pages.update', $page->id) }}">
    @csrf

    <input type="text" name="title" value="{{ $page->title }}"><br><br>

    <textarea name="content" class="summernote">{{ $page->content }}</textarea>

    <button type="submit">Update</button>
</form>

@endsection
 