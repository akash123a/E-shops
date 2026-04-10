@extends('admin.layout')

@section('content')

<h1>Welcome {{ $admin->name }}</h1>

<p>Email: {{ $admin->email }}</p>

<h2>Your Groups</h2>

<form method="POST" action="{{ route('group.index') }}">
    @csrf
    <input type="text" name="name" placeholder="Group Name">
    <button>Create</button>
</form>

@foreach($groups as $group)

    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

        <h3>Group: {{ $group->name }}</h3>

        <p><strong>Created by:</strong> {{ $group->creator->name ?? 'N/A' }}</p>

        <p><strong>Members:</strong></p>
        <ul>
            @forelse($group->users as $user)
                <li>{{ $user->name }}</li>
            @empty
                <li>No members yet</li>
            @endforelse
        </ul>
<a href="{{ route('group.showAddUserForm', $group->id) }}">
    <button type="button">Add User</button>
</a>
<a href="{{ route('expense.form', $group->id) }}">
    <button type="button">Add Expense</button>
</a>

<h2>Final Settlements</h2>

@if(!empty($settlements))
    @foreach($settlements as $s)
        <p>
    {{ optional($group->users->find($s['from']))->name ?? 'Unknown' }}
    pays ₹{{ $s['amount'] }} to
    {{ optional($group->users->find($s['to']))->name ?? 'Unknown' }}
</p>
    @endforeach
@else
    <p>No settlements yet</p>
@endif
    </div>

@endforeach

<h2>Hisab (Balances)</h2>

@foreach($balances as $user => $amount)
    <p>User {{ $user }} : ₹ {{ $amount }}</p>
@endforeach

<a href="/admin/change-password">Change Password</a><br><br>
<a href="/admin/logout">Logout</a>

@endsection