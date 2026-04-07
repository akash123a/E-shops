<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseSplit extends Model
{
    protected $fillable = ['expense_id','user_id','amount'];

    public $timestamps = false;
}