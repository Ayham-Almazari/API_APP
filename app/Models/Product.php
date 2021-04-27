<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $hidden=[
        "availability",
        "created_at",
        "updated_at"
    ];
    //accessors
    /**
     * Get the user's user name.
     *
     * @param  string  $value
     * @return string
     */
    public function getProductPictureAttribute($value)
    {
        if (!is_null($value)) {
            return asset('storage/'.$value);
        }
    }

    //relations
    public function under_category() {
        return $this->belongsTo(Category::class,"category_id");
    }
    public function offer() {
        return $this->hasOne(Offer::class);
    }
    public function BuyersAddMeToCarts()
    {
       return
       $this->belongsToMany(Buyer::class,'carts','buyer_id','product_id')
            ->using(Cart::class)
            ->as('cart')
            ->withPivot('quantity')
            ->withTimestamps();
    }
    public function Me_In_Orders_Details()
    {
        return
            $this->hasMany(OrderDetails::class ,'product_id');
    }
}
