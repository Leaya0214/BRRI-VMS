<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $guarded = [];

    public function created_user() {
        return $this->belongsTo(Employee::class, 'created_by', 'id' );
    }

    public function modiifed_user() {
        return $this->belongsTo(Employee::class, 'modiifed_by', 'id' );
    }
}
