<?php

namespace App\Models;

use Database\Factories\OrderFactory;
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
    public function _factory(array $attributes = [])
    {
     return $this->belongsTo(Factory::class,'factory_id');
    }
    public function _buyer(array $attributes = [])
    {
    return $this->belongsTo(Buyer::class,'buyer_id');
    }
    function factory_() {
        return $this->hasOne(FactoryOrder::class,'order_id');
    }
    function buyer_() {
        return $this->hasOne(BuyerOrder::class,'order_id');
    }
    function owner_() {
        return $this->hasOne(OwnerOrder::class,'order_id');
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
