@extends('admin.layout')

@section('content')

<h2>Edit Expense</h2>

<form method="POST" action="{{ route('expense.update', $expense->id) }}">
    @csrf

    <label>Paid By:</label><br>
    <select name="paid_by" required>
        @foreach($group->users as $user)
            <option value="{{ $user->id }}" 
                {{ $expense->paid_by == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    <br><br>

    <input type="text" name="description" value="{{ $expense->description }}" required>
    <input type="number" name="amount" value="{{ $expense->amount }}" step="0.01" required>
    <input type="text" name="category" value="{{ $expense->category }}">

    <button type="submit">Update Expense</button>
</form>

<br>
<a href="{{ route('expense.form', $expense->group_id) }}">⬅ Back</a>

@endsection