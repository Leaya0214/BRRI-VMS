<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleAssign extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function requisition()
    {
        return $this->belongsTo(VehicleRequisition::class, 'requisition_id', 'id');

    }
    public function driver()
    {
        return $this->belongsTo(Employee::class, 'driver_id', 'id');

    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');

    }
    public function assign_admin()
    {
        return $this->belongsTo(Employee::class, 'assigned_by', 'id');

    }
}
