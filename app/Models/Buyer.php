<?php

namespace App\Models;

use App\Observers\BuyerObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use phpDocumentor\Reflection\Types\Self_;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;
class Buyer extends Authenticatable implements JWTSubject,MustVerifyEmail
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
        'phone_verified_at'
    ];

    protected $dateFormat="Y-m-d H:i:s";
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
            "role"=>'buyer',
        ];
    }

    //relations

    public function profile(){
        return $this->hasOne(UsersProfiles::class,'buyer_id');
    }
}
