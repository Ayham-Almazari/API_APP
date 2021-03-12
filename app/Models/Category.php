<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $dateFormat="Y-m-d H:i:s";

    public function sub_categories() {
        return $this->hasMany(Category::class);
    }

    public function main_category() {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
