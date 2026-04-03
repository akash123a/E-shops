

@extends('admin.layout')

@section('content') 



<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h1>Welcome {{ $admin->name }}</h1>

<p>Email: {{ $admin->email }}</p>
 

<a href="/admin/change-password">Change Password</a><br><br>
<a href="/admin/logout">Logout</a>



@endsection
</body>
</html>