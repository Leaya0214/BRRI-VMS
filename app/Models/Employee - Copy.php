<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;

class Employee extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded =[];

    public function designation(){
        return $this->belongsTo(Designation::class,'designation_id','id');
    }

    public function section(){
        return $this->belongsTo(Section::class,'section_id','id');
    }


     protected $hidden = [
        'password',
        'remember_token',
    ];

     public function permissions()
    {
        return $this->belongsTo(MenuPermission::class,'id','user_id');
    }

    public function givePermissionTo($permission)
    {
        $this->permissions()->save(MenuPermission::whereName($permission)->firstOrFail());
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

      public function getJWTIdentifier()
    {
        return $this->getKey(); // Typically, this is the primary key (e.g., ID)
    }

    /**
     * Return a key-value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


}
