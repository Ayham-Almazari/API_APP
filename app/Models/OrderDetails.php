<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
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
    //relations ----------------------------------------start--------------------------------------------
   function for_order() {
    return $this->belongsTo(Order::class,'order_id');
   }

    function product() {
        return $this->belongsTo(Product::class,'product_id');
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
