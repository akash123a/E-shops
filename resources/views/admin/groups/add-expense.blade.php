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

<form method="POST" action="{{ route('expense.store') }}">
    @csrf

    <input type="hidden" name="group_id" value="{{ $group->id }}">

    {{-- Paid By Select --}}
    <label>Paid By:</label><br>
    <select name="paid_by" required>
        <option value="">-- Select User --</option>
        @foreach($group->users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
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
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

        <p>
            <strong>{{ $expense->description }}</strong>  
            - ₹ {{ $expense->amount }}  
            by <b>{{ $expense->payer->name }}</b>
        </p>

        {{-- SPLIT BUTTON --}}
        @if($expense->splits->isEmpty())
            <form method="POST" action="{{ route('expense.split', $expense->id) }}" style="display:inline">
                @csrf
                <button type="submit">Split Expense</button>
            </form>
        @else
            <span style="color:green;">✔ Already Split</span>
        @endif

        {{-- EDIT BUTTON --}}
        <a href="{{ route('expense.edit', $expense->id) }}">
            <button type="button" style="margin-left:10px;">Edit</button>
        </a>

        {{-- DELETE BUTTON --}}
        <form method="POST" action="{{ route('expense.delete', $expense->id) }}" style="display:inline">
            @csrf
            <button type="submit" 
                style="margin-left:10px; color:white; background:red;"
                onclick="return confirm('Are you sure you want to delete this expense?')">
                Delete
            </button>
        </form>

    </div>
@endforeach

<br>
<a href="{{ route('admin.dashboard') }}">⬅ Back to Dashboard</a>
@endsection