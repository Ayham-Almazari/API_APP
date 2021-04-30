<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Storage;

class Owner extends Authenticatable implements JWTSubject
{
    use HasFactory,Notifiable,MustVerifyEmail,SoftDeletes;
    protected $dateFormat="Y-m-d H:i:s";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'created_at',
        "updated_at",
        'password_rested_at',
        'email_verified_at',
        'phone_verified_at',
        'deleted_at',
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
            "role"=>'owner'
        ];
    }


    //scopes-----------------------------------------------------------------
    public function isAdmin(){
        return false;
    }
    public function isOwner(){
        return true;
    }
    public function isBuyer(){
        return false;
    }
    //relations-----------------------------------------------------------

    public function profile(){
        return $this->hasOne(UsersProfiles::class,'owner_id');
    }

    public function factories(){
        return $this->hasMany(Factory::class,'owner_id');
    }

    //accessors--------------------------------------------------------------------
    /**
     * Get the user's user name.
     *
     * @param  string  $value
     * @return string
     */
    public function getPropertyFileAttribute($value)
    {
        if (Str::contains($value,'https://')) {
            return $value;
        }else{
            return asset('storage/'.$value);
        }
    }
}
