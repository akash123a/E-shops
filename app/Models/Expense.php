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

    public function group(){
        return $this->belongsTo(Group::class);
    }

public function user()
{
    return $this->belongsTo(User::class, 'paid_by');
}
    public function payer()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}