<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseSplit;
use App\Models\Group;
use App\Models\Admin;

class ExpenseController extends Controller
{
    // Show form to add expense to a group
 public function showAddExpenseForm($groupId)
{
    $group = Group::with('users')->findOrFail($groupId);

    // Get current admin from session
    $currentUser = session('admin') ? Admin::find(session('admin')) : null;

    if (!$currentUser) {
        return redirect('/admin/login');
    }

    return view('admin.groups.add-expense', compact('group', 'currentUser'));
}

    // Store expense (without splitting yet)
    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string',
            'category' => 'nullable|string',
        ]);

        $expense = Expense::create([
            'group_id' => $request->group_id,
            'paid_by' => $request->paid_by , // default to first user
            'amount' => $request->amount,
            'description' => $request->description,
            'category' => $request->category,
        ]);

        return back()->with('success', 'Expense Added. Click Split to divide among members.');
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