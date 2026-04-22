@extends('admin.layout')

@section('content')

<h2>Add Expense</h2>

<form method="POST" action="{{ route('expense.store') }}">
    @csrf

    <input type="hidden" name="group_id" value="{{ $group->id }}">

    <label>Paid By</label>
    <select name="paid_by">
        @foreach($group->users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <br><br>

    <label>Description</label>
    <input type="text" name="description">

    <br><br>

    <label>Amount</label>
    <input type="number" name="amount">

    <br><br>

    <label>Category</label>
    <input type="text" name="category">

    <br><br>

    <button type="submit">Save</button>
</form>

@endsection