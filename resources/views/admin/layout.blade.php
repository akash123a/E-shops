<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #1e293b;
            color: #fff;
            padding: 20px;
        }

        .sidebar h4 {
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #cbd5e1;
            padding: 10px;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #3b82f6;
            color: #fff;
        }

        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Admin Panel</h4>

        <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>

        <a href="/admin/users" class="{{ request()->is('admin/users*') ? 'active' : '' }}">Users</a>
 
        <a href="/admin/sliders" class="{{ request()->is('admin/sliders.index') ? 'active' : '' }}">Sliders</a>

        <a href="/admin/change-password" class="{{ request()->is('admin/change-password') ? 'active' : '' }}">Change Password</a>

        <a href="/admin/logout">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

</body>
</html>