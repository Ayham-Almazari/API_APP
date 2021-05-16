<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactoryPermissions extends Model
{
    use HasFactory;
    protected $guarded=[];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'can_add_category'=>'boolean',
        'can_update_category'=>'boolean',
        'can_add_product'=>'boolean',
        'can_add_product'
    ];
    public $timestamps=false;
    public function F_P(array $attributes = []) {
        return $this->belongsTo(Factory::class,'factory_id');
    }


}
