@extends('admin.layout')

@section('content')

<h2>Create Page</h2>

<form method="POST" action="{{ route('pages.store') }}">
    @csrf

    <input type="text" name="title" placeholder="Page Title"><br><br>

    <textarea name="content" class="summernote"></textarea>

    <button type="submit">Save</button>
</form>

@endsection

{{-- Summernote --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
$(document).ready(function () {
    $('.summernote').summernote({
        height: 300
    });
});
</script>