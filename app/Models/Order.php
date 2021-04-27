<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Order extends Pivot
{
    use HasFactory;
    protected $table='orders';
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
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    //relations ----------------------------------------start--------------------------------------------
    function Details() {
        return $this->hasMany(OrderDetails::class,'order_id');
    }

    function factory_() {
        return $this->belongsTo(Factory::class,'factory_id');
    }
    function buyer_() {
        return $this->belongsTo(Buyer::class,'buyer_id');
    }
    //relations ----------------------------------------end--------------------------------------------

    //accessors ---------------------------------------start--------------------------------------------
    /**
     * Get total_amount number format  .
     *
     * @param  string  $value
     * @return string
     */
    public function getTotalAmountAttribute($value)
    {
            return number_format($value,2);
    }
    //accessors ----------------------------------------end--------------------------------------------

}
