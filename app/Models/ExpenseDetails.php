<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseDetails extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function expenseCategory(){
        return $this->belongsTo(VehicleExpenseCategory::class,'category_id','id');
    }
    public function expenseHead(){
        return $this->belongsTo(VehicleExpenseHead::class,'head_id','id');
    }
    public function expenseMaster(){
        return $this->belongsTo(ExpenseMaster::class,'expense_master_id','id');
    }
    
}
