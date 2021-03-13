<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $dateFormat="Y-m-d H:i:s";

    public function under_category() {
       return $this->belongsTo(Category::class,"category_id");
    }

    public function offer() {
        return $this->hasOne(Offer::class);
    }
}