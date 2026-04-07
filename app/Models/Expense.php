<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Expense extends Model
{
    protected $fillable = [
        'group_id','paid_by','amount','description','category'
    ];

    public function splits()
    {
        return $this->hasMany(ExpenseSplit::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}