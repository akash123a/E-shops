<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>

<h2>Change Password</h2>

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

@if($errors->any())
    <div style="color:red;">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="/admin/change-password">
    @csrf

    <input type="password" name="current_password" placeholder="Current Password"><br><br>

    <input type="password" name="new_password" placeholder="New Password"><br><br>

    <input type="password" name="new_password_confirmation" placeholder="Confirm New Password"><br><br>

    <button type="submit">Update Password</button>
</form>

<br>
<a href="/admin/dashboard">Back to Dashboard</a>

</body>
</html>