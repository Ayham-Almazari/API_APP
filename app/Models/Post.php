<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $dateFormat="Y-m-d H:i:s";

    protected $guarded=[

    ];

    protected $casts=[
        'likes'=>'integer'
    ];

    public function user()
    {
        return $this->belongsTo(Buyer::class);
    }
}
