<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Factory extends Model
{
    use HasFactory;

    protected $dateFormat="Y-m-d H:i:s";

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
        'password'
    ];

//    protected $with ='owner.profile';

    //relations
    public function owner() {
        return $this->belongsTo(Owner::class,'owner_id');
    }
}
