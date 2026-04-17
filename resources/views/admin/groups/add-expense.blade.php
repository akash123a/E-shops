@extends('admin.layout')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .expense-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: #f0f2f5;
        min-height: 100vh;
    }

    /* Header */
    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 700;
        background: linear-gradient(135deg, #1e293b, #334155);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 8px;
    }

    .group-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 14px;
        font-weight: 500;
        color: white;
    }

    /* Alert Messages */
    .alert {
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-weight: 500;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-success {
        background: #d1fae5;
        border-left: 4px solid #10b981;
        color: #065f46;
    }

    .alert-error {
        background: #fee2e2;
        border-left: 4px solid #ef4444;
        color: #991b1b;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .form-header {
        padding: 18px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .form-header h3 {
        font-size: 18px;
        font-weight: 600;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-body {
        padding: 24px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #334155;
    }

    .form-group label i {
        margin-right: 6px;
        color: #94a3b8;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    /* User Sections - Different Cards for Each User */
    .users-expenses-container {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .user-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .user-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    /* User Header */
    .user-header {
        padding: 16px 24px;
        background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
        border-bottom: 2px solid #667eea;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 18px;
    }

    .user-details h4 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .user-details p {
        font-size: 13px;
        color: #64748b;
    }

    .user-stats {
        display: flex;
        gap: 20px;
    }

    .stat-badge {
        text-align: center;
        padding: 8px 16px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .stat-badge .stat-value {
        font-size: 20px;
        font-weight: 800;
        color: #667eea;
    }

    .stat-badge .stat-label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Expenses Table for Each User */
    .expenses-table-wrapper {
        overflow-x: auto;
    }

    .expenses-table {
        width: 100%;
        border-collapse: collapse;
    }

    .expenses-table th {
        text-align: left;
        padding: 14px 20px;
        background: #f8fafc;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }

    .expenses-table td {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        vertical-align: middle;
    }

    .expenses-table tr:hover {
        background: #f8fafc;
    }

    .expense-description {
        font-weight: 600;
        color: #1e293b;
    }

    .expense-category {
        display: inline-block;
        padding: 4px 10px;
        background: #e2e8f0;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
        color: #475569;
    }

    .expense-amount {
        font-weight: 700;
        color: #059669;
        font-size: 15px;
    }

    .split-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
    }

    .split-status.splitted {
        background: #d1fae5;
        color: #065f46;
    }

    .split-status.pending {
        background: #fed7aa;
        color: #92400e;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-icon {
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 8px;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
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

    .empty-user-expenses {
        padding: 40px;
        text-align: center;
        color: #94a3b8;
    }

    .empty-user-expenses i {
        font-size: 40px;
        margin-bottom: 12px;
        opacity: 0.5;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 25px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #667eea;
    }

    /* Total Summary Bar */
    .summary-bar {
        background: white;
        border-radius: 16px;
        padding: 15px 24px;
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .total-amount {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
    }

    .total-amount span {
        color: #667eea;
        font-size: 26px;
    }

    @media (max-width: 768px) {
        .expense-container {
            padding: 15px;
        }
        
        .user-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .expenses-table th,
        .expenses-table td {
            padding: 10px 12px;
        }
    }
</style>

<div class="expense-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-receipt"></i> Expense Management</h1>
        <div class="group-badge">
            <i class="fas fa-users"></i> {{ $group->name }}
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i> Please fix the following errors:
            @foreach($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Add Expense Form -->
    <div class="form-card">
        <div class="form-header">
            <h3><i class="fas fa-plus-circle"></i> Add New Expense</h3>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('expense.store') }}">
                @csrf
                <input type="hidden" name="group_id" value="{{ $group->id }}">
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Paid By</label>
                        <select name="paid_by" required>
                            <option value="">-- Select User --</option>
                            @foreach($group->users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Category</label>
                        <input type="text" name="category" placeholder="Food, Travel, Shopping...">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-align-left"></i> Description</label>
                        <input type="text" name="description" placeholder="Expense description" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-rupee-sign"></i> Amount (₹)</label>
                        <input type="number" name="amount" placeholder="0.00" step="0.01" required>
                    </div>
                </div>
                
                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Expense
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Bar -->
    @php
        $totalExpenses = $group->expenses->sum('amount');
    @endphp
    <div class="summary-bar">
        <div>
            <i class="fas fa-chart-line"></i> Total Group Expenses
        </div>
        <div class="total-amount">
            <i class="fas fa-rupee-sign"></i> <span>{{ number_format($totalExpenses, 2) }}</span>
        </div>
    </div>

    <!-- User-wise Expense Sections -->
    <div class="users-expenses-container">
        @foreach($group->users as $user)
            @php
                $userExpenses = $group->expenses->where('paid_by', $user->id);
                $userTotal = $userExpenses->sum('amount');
                $expenseCount = $userExpenses->count();
            @endphp
            
            <div class="user-section">
                <div class="user-header">
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div class="user-details">
                            <h4>{{ $user->name }}</h4>
                            <p><i class="fas fa-envelope"></i> {{ $user->email ?? 'No email' }}</p>
                        </div>
                    </div>
                    <div class="user-stats">
                        <div class="stat-badge">
                            <div class="stat-value">{{ $expenseCount }}</div>
                            <div class="stat-label">Expenses</div>
                        </div>
                        <div class="stat-badge">
                            <div class="stat-value">₹ {{ number_format($userTotal, 2) }}</div>
                            <div class="stat-label">Total Paid</div>
                        </div>
                    </div>
                </div>
                
                <div class="expenses-table-wrapper">
                    @if($userExpenses->isEmpty())
                        <div class="empty-user-expenses">
                            <i class="fas fa-receipt"></i>
                            <p>No expenses added by {{ $user->name }} yet.</p>
                        </div>
                    @else
                        <table class="expenses-table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Split Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userExpenses as $expense)
                                    <tr>
                                        <td class="expense-description">
                                            <i class="fas fa-file-invoice"></i> {{ $expense->description }}
                                        </td>
                                        <td>
                                            @if($expense->category)
                                                <span class="expense-category">
                                                    <i class="fas fa-folder"></i> {{ $expense->category }}
                                                </span>
                                            @else
                                                <span style="color: #cbd5e1;">—</span>
                                            @endif
                                        </td>
                                        <td class="expense-amount">
                                            <i class="fas fa-rupee-sign"></i> {{ number_format($expense->amount, 2) }}
                                        </td>
                                        <td style="color: #64748b; font-size: 12px;">
                                            <i class="fas fa-calendar-alt"></i> {{ $expense->created_at->format('d M Y') }}
                                        </td>
                                        <td>
                                            @if($expense->splits->isEmpty())
                                                <span class="split-status pending">
                                                    <i class="fas fa-clock"></i> Not Split
                                                </span>
                                            @else
                                                <span class="split-status splitted">
                                                    <i class="fas fa-check-circle"></i> Split Done
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                @if($expense->splits->isEmpty())
                                                    <form method="POST" action="{{ route('expense.split', $expense->id) }}" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn-icon btn-success" style="padding: 5px 12px;">
                                                            <i class="fas fa-code-branch"></i> Split
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <a href="{{ route('expense.edit', $expense->id) }}">
                                                    <button type="button" class="btn-icon btn-warning" style="padding: 5px 12px;">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                </a>
                                                
                                                <form method="POST" action="{{ route('expense.delete', $expense->id) }}" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-icon btn-danger" style="padding: 5px 12px;" 
                                                        onclick="return confirm('Delete this expense? This action cannot be undone.')">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Back Link -->
    <a href="{{ route('admin.dashboard') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a0c6e2c9d8.js" crossorigin="anonymous"></script>
@endsection