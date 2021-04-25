<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $dateFormat="Y-m-d H:i:s";

    function OrderDetails() {
        return $this->hasMany(OrderDetails::class,'order_id');
    }
}
