<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UsersProfiles extends Model
{
    use HasFactory;
    protected $dateFormat="Y-m-d H:i:s";

    protected $guarded=[];
    protected $hidden=[
        'created_at',
        "updated_at",
        'email_verified_at',
        "phone_verified_at",
        "admin_id",
        "buyer_id",
        "owner_id"
    ];


    //relations-------------------------------------------------------------------
    public function buyer() {
        return $this->belongsTo(Buyer::class,'buyer_id');
    }

    public function admin() {
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function owner() {
        return $this->belongsTo(Owner::class,'owner_id');
    }

    //accessors------------------------------------------------------------------
    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }
    /**
     * Get the user's last name.
     *
     * @param  string  $value
     * @return string
     */
    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }
    public function getPictureAttribute($value)
    {
        if (Str::contains($value, 'https://')) {
            return $value;
        } elseif (is_null($value)){
            return asset('myimage.jpg');
        }else{
            return asset('storage/'.$value);
        }
    }

}
