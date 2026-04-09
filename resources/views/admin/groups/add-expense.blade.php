@extends('admin.layout')

@section('content')
<h2>Add Expense to {{ $group->name }}</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if($errors->any())
    <div style="color:red;">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

{{-- Add Expense Form --}}
<form method="POST" action="{{ route('expense.store') }}">
    @csrf

    {{-- Hidden Group ID --}}
    <input type="hidden" name="group_id" value="{{ $group->id }}">

    {{-- Hidden paid_by field with logged-in user's ID --}}
    <input type="hidden" name="paid_by" value="{{ $currentUser->id }}">

    {{-- Show current user name --}}
    <label>Paid By:</label><br>
    <input type="text" value="{{ $currentUser->name }}" disabled>
    <br><br>

    <input type="text" name="description" placeholder="Expense Description" required>
    <input type="number" name="amount" placeholder="Amount" step="0.01" required>
    <input type="text" name="category" placeholder="Category (optional)">
    <button type="submit">Add Expense</button>
</form>

<hr>

{{-- List of Expenses --}}
<h3>Expenses</h3>
@foreach($group->expenses as $expense)
    <p>
        {{ $expense->description }} - ₹ {{ $expense->amount }} 
        by {{ $expense->payer->name }}
        @if($expense->splits->isEmpty())
            <form method="POST" action="{{ route('expense.split', $expense->id) }}" style="display:inline">
                @csrf
                <button type="submit">Split Expense</button>
            </form>
        @else
            <small>Already Split</small>
        @endif
    </p>
@endforeach

<br>
<a href="{{ route('admin.dashboard') }}">⬅ Back to Dashboard</a>
@endsection