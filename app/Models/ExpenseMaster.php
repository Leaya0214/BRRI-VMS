<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseMaster extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function vehicelInfo(){
        return $this->belongsTo(Vehicle::class,'vehicle_id','id');
    }

    public function expenseDetails(): HasMany
    {
        return $this->hasMany(ExpenseDetails::class, 'expense_master_id', 'id');
    }
    
    public function getTotalExpenseAmountAttribute()
    {
        return $this->expenseDetails->sum('amount');
    }
}
