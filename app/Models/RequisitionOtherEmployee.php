<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionOtherEmployee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function requisition(){
        return $this->belongsTo(VehicleRequisition::class,'requisition_id','id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }
}
