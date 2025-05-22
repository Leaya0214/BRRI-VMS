<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleExpenseHead extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function expenseCategory(){
        return $this->belongsTo(VehicleExpenseCategory::class, 'category_id','id');  
    }
}
