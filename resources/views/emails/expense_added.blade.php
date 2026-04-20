<h2>New Expense Added</h2>

<p>Hello {{ $user->name }},</p>

<p><strong>Description:</strong> {{ $expense->description }}</p>
<p><strong>Amount:</strong> ₹ {{ $expense->amount }}</p>
<p><strong>Category:</strong> {{ $expense->category }}</p>
<p><strong>Paid By:</strong> {{ $expense->user->name }}</p>

<hr>

<h3>Your Summary</h3>

@php
    $userExpenses = $group->expenses->where('paid_by', $user->id);
@endphp

<p><strong>Total You Paid:</strong> ₹ {{ $userExpenses->sum('amount') }}</p>
<p><strong>No. of Expenses:</strong> {{ $userExpenses->count() }}</p>

<hr>

<h3>Group Summary</h3>

<ul>
@foreach($group->users as $member)
    @php
        $expenses = $group->expenses->where('paid_by', $member->id);
    @endphp

    <li>
        {{ $member->name }} → ₹ {{ $expenses->sum('amount') }}
        ({{ $expenses->count() }} expenses)
    </li>
@endforeach
</ul>