<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleRequisition extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['usage_date','requisition_date'];

    public function district(){
        return $this->belongsTo(District::class, 'district_id', 'id');

    }

    public function type(){
        return $this->belongsTo(VehicleType::class, 'type_id', 'id');

    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id', 'id');

    }

    public function head(){
        return $this->belongsTo(Employee::class, 'dept_head_id', 'id');

    }

    public function assign(){
        return $this->hasOne(VehicleAssign::class, 'requisition_id', 'id');

    }

    public function other_employee(){
        return $this->hasMany(RequisitionOtherEmployee::class, 'requisition_id', 'id');
    }




}
