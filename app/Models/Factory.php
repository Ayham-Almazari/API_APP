<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Factory extends Model
{
    use HasFactory , SoftDeletes;

    protected $dateFormat="Y-m-d H:i:s";
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => "datetime:Y-m-d H:i:s"
    ];

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
        'password','property_file'
    ];
        //accessors
    /**
     * Get prperty file from public.
     *
     * @param  string  $value
     * @return string
     */
    public function getPropertyFileAttribute($value)
    {
        return asset('storage/'.$value);
    }
    public function getCoverPhotoAttribute($value)
    {
        if (!is_null($value)) {
            return asset('storage/'.$value);
        }
    }
    public function getLogoAttribute($value)
    {
        if (!is_null($value)) {
            return asset('storage/'.$value);
        }
    }

//    protected $with ='owner.profile';

    //relations
    public function owner() {
        return $this->belongsTo(Owner::class,'owner_id');
    }

    public function categories() {
        return $this->hasMany(Category::class,'factory_id');
    }
}
