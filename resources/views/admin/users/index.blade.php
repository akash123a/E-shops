@extends('admin.layout')

@section('content')

<style>
    .user-container {
        padding: 20px;
    }

    .user-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .user-header {
        padding: 16px 20px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        font-size: 18px;
        font-weight: 600;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #f8fafc;
    }

    th {
        text-align: left;
        padding: 14px;
        font-size: 13px;
        color: #64748b;
        text-transform: uppercase;
    }

    td {
        padding: 14px;
        border-top: 1px solid #f1f5f9;
        font-size: 14px;
    }

    tr:hover {
        background: #f9fafb;
    }

    .btn {
        padding: 6px 12px;
        font-size: 13px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        margin-right: 5px;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .empty {
        text-align: center;
        padding: 30px;
        color: #94a3b8;
    }
</style>

<div class="user-container">
    <div class="user-card">

        <div class="user-header">
            👤 Users List
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td style="text-align:right;">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="empty">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection