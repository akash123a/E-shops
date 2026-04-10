<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseSplit;
use App\Models\Group;
use App\Models\Admin;
use App\Models\User;

class ExpenseController extends Controller
{


public function create($groupId)
{
    $group = \App\Models\Group::with('users', 'expenses.payer')->findOrFail($groupId);

    // Optional: current user (if needed)
    $currentUser = null;

   return view('admin.groups.add-expense', compact('group'));
}


    // Show form to add expense to a group
public function showAddExpenseForm($groupId)
{
    $group = Group::with('users')->findOrFail($groupId);

    $admin = Admin::find(session('admin'));

    // ✅ Find matching user using email
    $currentUser = User::where('email', $admin->email)->first();

    if (!$currentUser) {
        return back()->withErrors('User not found for this admin');
    }

    return view('admin.groups.add-expense', compact('group', 'currentUser'));
}

    // Store expense (without splitting yet)
public function store(Request $request)
{
    $request->validate([
        'group_id' => 'required|exists:groups,id',
        'paid_by' => 'required|exists:users,id', // ✅ important
        'amount' => 'required|numeric|min:1',
        'description' => 'required|string',
        'category' => 'nullable|string',
    ]);

    Expense::create([
        'group_id' => $request->group_id,
        'paid_by' => $request->paid_by,
        'amount' => $request->amount,
        'description' => $request->description,
        'category' => $request->category,
    ]);

    return back()->with('success', 'Expense Added Successfully!');
}



// ===============================
// ✅ CALCULATE BALANCES
// ===============================
public function calculateBalances($groupId)
{
    $group = Group::with('users', 'expenses.splits')->findOrFail($groupId);

    $balances = [];

    // Initialize
    foreach ($group->users as $user) {
        $balances[$user->id] = 0;
    }

    // Add paid amount
    foreach ($group->expenses as $expense) {
        $balances[$expense->paid_by] += $expense->amount;
    }

    // Subtract split amount
    foreach ($group->expenses as $expense) {
        foreach ($expense->splits as $split) {
            $balances[$split->user_id] -= $split->amount;
        }
    }

    return $balances;
}


// ===============================
// ✅ SIMPLIFY DEBTS (WHO PAYS WHOM)
// ===============================
public function simplifyDebts($balances)
{
    $creditors = [];
    $debtors = [];

    foreach ($balances as $userId => $amount) {
        if ($amount > 0) {
            $creditors[] = ['user_id' => $userId, 'amount' => $amount];
        } elseif ($amount < 0) {
            $debtors[] = ['user_id' => $userId, 'amount' => abs($amount)];
        }
    }

    $transactions = [];

    $i = 0; $j = 0;

    while ($i < count($debtors) && $j < count($creditors)) {

        $min = min($debtors[$i]['amount'], $creditors[$j]['amount']);

        $transactions[] = [
            'from' => $debtors[$i]['user_id'],
            'to' => $creditors[$j]['user_id'],
            'amount' => $min
        ];

        $debtors[$i]['amount'] -= $min;
        $creditors[$j]['amount'] -= $min;

        if ($debtors[$i]['amount'] == 0) $i++;
        if ($creditors[$j]['amount'] == 0) $j++;
    }

    return $transactions;
}

    // Split an expense among group members
 public function splitExpense($expenseId)
{
    $expense = Expense::with('group.users')->findOrFail($expenseId);

    $users = $expense->group->users;
    $splitAmount = $expense->amount / $users->count();

    foreach ($users as $user) {
        $exists = $expense->splits()->where('user_id', $user->id)->exists();

        if (!$exists) {
            ExpenseSplit::create([
                'expense_id' => $expense->id,
                'user_id' => $user->id,
                'amount' => $splitAmount,
            ]);
        }
    }

    return back()->with('success', 'Expense split among group members.');
}
}