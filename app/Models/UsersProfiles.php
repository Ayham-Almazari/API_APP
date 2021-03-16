<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersProfiles extends Model
{
    use HasFactory;
    protected $dateFormat="Y-m-d H:i:s";

    protected $guarded=[];
    protected $hidden=[
        'created_at',
        "updated_at",
        'email_verified_at',
        "phone_verified_at"
        ];

    public function buyer() {
        return $this->belongsTo(Buyer::class,'buyer_id');
    }

    public function admin() {
        return $this->belongsTo(Admin::class,'admin_id');
    }
}
