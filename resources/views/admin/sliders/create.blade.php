<h2>Add Slider</h2>

<form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="title" placeholder="Title">
    <input type="file" name="image">

    <button type="submit">Save</button>
</form>