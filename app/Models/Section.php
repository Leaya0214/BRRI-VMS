<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'tbl_section';

    public $timestamps = false;


    public function employees()
        {
            return $this->hasMany(Employee::class);
        }
    public function created_user() {
        return $this->belongsTo(Employee::class, 'created_by', 'id' );
    }

    public function modiifed_user() {
        return $this->belongsTo(Employee::class, 'modiifed_by', 'id' );
    }



}
