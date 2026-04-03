<h2>Edit Slider</h2>

<form action="{{ route('sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="text" name="title" value="{{ $slider->title }}">

    <img src="{{ asset('uploads/sliders/'.$slider->image) }}" width="100">

    <input type="file" name="image">

    <button type="submit">Update</button>
</form>