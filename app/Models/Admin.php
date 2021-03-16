<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends  Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable,MustVerifyEmail;
    protected $dateFormat="Y-m-d H:i:s";

    protected $table="admins";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $guarded=[];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_me',
        'created_at',
        "updated_at",
        'password_rested_at','email_verified_at','phone_verified_at'
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            "role"=>'admin'
        ];
    }

    //relations

    public function profile(){
        return $this->hasOne(UsersProfiles::class,'admin_id');
    }
}
