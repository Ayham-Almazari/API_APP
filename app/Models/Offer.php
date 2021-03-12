<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $dateFormat="Y-m-d H:i:s";

    public function for_product() {
        return $this->belongsTo(Product::class,"product_id");
    }

}
