@extends('admin.layout')

@section('content')

<h2>Expense Dashboard</h2>

<a href="{{ route('expense.form', $group->id) }}" class="btn btn-primary">
    + Add Expense
</a>

<hr>

<!-- CHARTS -->
<div style="display:flex; gap:30px; flex-wrap:wrap;">
    <canvas id="categoryChart" width="300"></canvas>
    <canvas id="userChart" width="300"></canvas>
    <canvas id="dateChart" width="300"></canvas>
</div>

<hr>

<!-- TABLE -->
<table border="1" cellpadding="10">
    <tr>
        <th>Description</th>
        <th>Amount</th>
        <th>Category</th>
        <th>User</th>
    </tr>

    @foreach($group->expenses as $expense)
    <tr>
        <td>{{ $expense->description }}</td>
        <td>₹ {{ $expense->amount }}</td>
        <td>{{ $expense->category }}</td>
        <td>{{ $expense->user->name }}</td>
    </tr>
    @endforeach
</table>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const categoryLabels = @json($categoryData->keys());
const categoryValues = @json($categoryData->values());

const userLabels = @json(collect($userData)->pluck('name'));
const userValues = @json(collect($userData)->pluck('total'));

const dateLabels = @json($dateData->keys());
const dateValues = @json($dateData->values());

// Category Pie
new Chart(document.getElementById('categoryChart'), {
    type: 'pie',
    data: {
        labels: categoryLabels,
        datasets: [{ data: categoryValues }]
    }
});

// User Bar
new Chart(document.getElementById('userChart'), {
    type: 'bar',
    data: {
        labels: userLabels,
        datasets: [{ data: userValues }]
    }
});

// Date Line
new Chart(document.getElementById('dateChart'), {
    type: 'line',
    data: {
        labels: dateLabels,
        datasets: [{ data: dateValues }]
    }
});
</script>

@endsection