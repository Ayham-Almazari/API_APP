<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersProfiles extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function buyer() {
        return $this->belongsTo(Buyer::class,'buyer_id');
    }
}
