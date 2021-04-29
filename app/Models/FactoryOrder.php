<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactoryOrder extends Model
{
    use HasFactory;
    protected $dateFormat="Y-m-d H:i:s";
    protected $guarded=[];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
    protected $hidden=[
        "created_at",
        "updated_at"
    ];
    //Relations start ------------------------------------------------------------------
    public function _factory(array $attributes = [])
    {
        return $this->belongsTo(Factory::class,'factory_id');
    }
    //Relations ends ------------------------------------------------------------------

}
