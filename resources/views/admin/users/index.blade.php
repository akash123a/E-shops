 
@extends('admin.layout')

@section('content')


 


<h2>All Users</h2>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created At</th>
        </tr>
    </thead>

    <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? 'N/A' }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No Users Found</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection