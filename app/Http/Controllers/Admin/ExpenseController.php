<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseSplit;
use App\Models\Group;
use App\Models\User;
use App\Services\WhatsAppService;

class ExpenseController extends Controller
{

    // ===============================
    // ✅ SEND WHATSAPP (LINK METHOD)
    // ===============================

    public function create($groupId)
{
    $group = \App\Models\Group::with('users')->findOrFail($groupId);

    return view('admin.groups.add-expense', compact('group'));
}


    public function store(Request $request)
{
    $request->validate([
        'group_id' => 'required|exists:groups,id',
        'paid_by' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:1',
        'description' => 'required|string',
        'category' => 'nullable|string',
    ]);

    \App\Models\Expense::create([
        'group_id' => $request->group_id,
        'paid_by' => $request->paid_by,
        'amount' => $request->amount,
        'description' => $request->description,
        'category' => $request->category,
    ]);

    return back()->with('success', 'Expense Added Successfully!');
}

public function edit($id)
{
    $expense = Expense::findOrFail($id);
    $group = Group::with('users')->findOrFail($expense->group_id);

    return view('admin.groups.edit-expense', compact('expense', 'group'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'paid_by' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:1',
        'description' => 'required|string',
        'category' => 'nullable|string',
    ]);

    $expense = Expense::findOrFail($id);

    $expense->update([
        'paid_by' => $request->paid_by,
        'amount' => $request->amount,
        'description' => $request->description,
        'category' => $request->category,
    ]);

    return redirect()->route('expense.form', $expense->group_id)
        ->with('success', 'Expense updated successfully!');
}


public function destroy($id)
{
    $expense = Expense::findOrFail($id);

    // delete splits first
    ExpenseSplit::where('expense_id', $expense->id)->delete();

    $groupId = $expense->group_id;

    $expense->delete();

    return redirect()->route('expense.form', $groupId)
        ->with('success', 'Expense deleted successfully!');
}

public function splitExpense($expenseId)
{
    $expense = \App\Models\Expense::with('group.users')->findOrFail($expenseId);

    $users = $expense->group->users;

    // Equal split
    $splitAmount = $expense->amount / $users->count();

    foreach ($users as $user) {

        $exists = \App\Models\ExpenseSplit::where([
            'expense_id' => $expense->id,
            'user_id' => $user->id
        ])->exists();

        if (!$exists) {
            \App\Models\ExpenseSplit::create([
                'expense_id' => $expense->id,
                'user_id' => $user->id,
                'amount' => $splitAmount,
            ]);
        }
    }

    return back()->with('success', 'Expense split successfully!');
}




  public function sendSettlementMessage($groupId)
{
    $group = \App\Models\Group::with('users')->findOrFail($groupId);

    $balances = $this->calculateBalances($groupId);
    $settlements = $this->simplifyDebts($balances);

    $message = "💰 Settlement Details\n\n";

    foreach ($settlements as $s) {
        $fromUser = $group->users->find($s['from']);
        $toUser = $group->users->find($s['to']);

        $message .= "{$fromUser->name} pays ₹{$s['amount']} to {$toUser->name}\n";
    }

    $whatsapp = new \App\Services\WhatsAppService();

    // सिर्फ FIRST user ke liye demo
    $user = $group->users->first();

    if ($user && $user->phone) {
        $url = $whatsapp->sendMessage($user->phone, $message);

        return redirect($url); // ✅ WhatsApp open hoga
    }

    return back()->with('error', 'No phone number found');
}

    // ===============================
    // बाकी तुम्हारा code (same रहेगा)
    // ===============================

    public function calculateBalances($groupId)
    {
        $group = Group::with('users', 'expenses.splits')->findOrFail($groupId);

        $balances = [];

        foreach ($group->users as $user) {
            $balances[$user->id] = 0;
        }

        foreach ($group->expenses as $expense) {
            $balances[$expense->paid_by] += $expense->amount;
        }

        foreach ($group->expenses as $expense) {
            foreach ($expense->splits as $split) {
                $balances[$split->user_id] -= $split->amount;
            }
        }

        return $balances;
    }

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
}