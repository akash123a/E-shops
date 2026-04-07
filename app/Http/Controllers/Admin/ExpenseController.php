<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function store(Request $request)
    {
        $expense = Expense::create([
            'group_id' => $request->group_id,
            'paid_by' => $request->paid_by,
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

        return back();
    }
}