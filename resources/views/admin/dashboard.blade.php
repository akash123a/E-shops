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

<div id="chat-box"></div>

<input type="text" id="msg">
<button onclick="sendMessage()">Send</button>

<form action="{{ route('send.whatsapp', $group->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-success">
        Send WhatsApp
    </button>
</form>

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

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
var pusher = new Pusher("qxJTySPY43z92bXjH6o9S1CFZI_RF_qUmnF6E5HyYG0", {
    cluster: "ap2"
});

var channel = pusher.subscribe("group.1");

channel.bind("message.sent", function(data) {
    document.getElementById("chat-box").innerHTML += `
        <p><b>User:</b> ${data.message.message}</p>
    `;
});
</script>


<script>
function sendMessage() {
    fetch('/send-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            message: document.getElementById('msg').value,
            group_id: 1
        })
    });
}
</script>

@endsection