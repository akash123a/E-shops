<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>
</head>
<body>

<h2>Admin Register</h2>

@if($errors->any())
    <div style="color:red;">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="/admin/register">
    @csrf

    <input type="text" name="name" placeholder="Name"><br><br>
    <input type="email" name="email" placeholder="Email"><br><br>

    <input type="password" name="password" placeholder="Password"><br><br>
    <input type="password" name="password_confirmation" placeholder="Confirm Password"><br><br>

    <button type="submit">Register</button>
</form>

<p>Already have account? <a href="/admin/login">Login</a></p>

</body>
</html>