<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    function product_() {
        return $this->belongsTo(Product::class,'order_id');
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
    //accessors
    /**
     * Get the user's user name.
     *
     * @param  string  $value
     * @return string
     */
    public function getProductPictureAttribute($value)
    {
        if (Str::contains($value,'https://')) {
            return $value;
        }else{
            return asset('storage/'.$value);
        }
    }
    //accessors ----------------------------------------end--------------------------------------------

}
