<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseSplit;

class ExpenseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string',
            'users' => 'required|array|min:1'
        ]);

        $expense = Expense::create([
            'group_id' => $request->group_id,
            'paid_by' => auth()->id(), // always logged-in user
            'amount' => $request->amount,
            'description' => $request->description
        ]);

        $users = $request->users;
        $splitAmount = $request->amount / count($users);

        foreach ($users as $user) {
            ExpenseSplit::create([
                'expense_id' => $expense->id,
                'user_id' => $user,
                'amount' => $splitAmount
            ]);
        }

        return back()->with('success', 'Expense Added');
    }
}