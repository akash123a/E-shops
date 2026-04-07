<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function show($groupId)
    {
        $expenses = Expense::with('splits')->where('group_id', $groupId)->get();

        $balances = [];

        foreach ($expenses as $expense) {
            foreach ($expense->splits as $split) {

                if ($split->user_id != $expense->paid_by) {
                    $balances[$split->user_id] =
                        ($balances[$split->user_id] ?? 0) - $split->amount;

                    $balances[$expense->paid_by] =
                        ($balances[$expense->paid_by] ?? 0) + $split->amount;
                }
            }
        }

        return view('balance.show', compact('balances'));
    }
}