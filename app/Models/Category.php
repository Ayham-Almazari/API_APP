<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory ;
    protected $guarded=[];
    protected $table='categories';
    protected $dateFormat="Y-m-d H:i:s";
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => "datetime:Y-m-d H:i:s"
    ];
    protected $hidden=[
        "created_at",
        "updated_at"
    ];
    public function products() {
        return $this->hasMany(Product::class);
    }
    public function factory__() {
        return $this->belongsTo(Factory::class,'factory_id');
    }
}
