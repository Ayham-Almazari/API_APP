<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Http\Traits\permissions\Factory as Factory_Permisions;

class Factory extends Model
{
    use HasFactory , SoftDeletes , Factory_Permisions;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded=[];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','property_file'
    ];
        //accessors
    /**
     * Get prperty file from public.
     *
     * @param  string  $value
     * @return string
     */
    public function getPropertyFileAttribute($value)
    {
        if (Str::contains($value,'https://')) {
            return $value;
        }elseif(is_null($value)){
            return $value;
        }else{
            return asset('storage/'.$value);
        }
    }
    public function getCoverPhotoAttribute($value)
    {
        if (Str::contains($value,'https://')) {
            return $value;
        }elseif(empty($value)){
            return asset('2227044.jpg');
        }else{
            return asset('storage/'.$value);
        }
    }
    public function getLogoAttribute($value)
    {
        if (Str::contains($value,'https://')) {
            return $value;
        }elseif(empty($value)){
            $logo = \Arr::random(['logos/datacolor.svg','logos/dos-pinos-1.svg'
                 ,'logos/maracaju-atletico-clube-de-maracaju-ms.svg',
                "logos/ms-4.svg","logos/ms-dos.svg","logos/ms-dos-prompt.svg","logos/Rainbow_Studios_logo.svg"]);
            return asset($logo);
        }else{
            return asset('storage/'.$value);
        }
    }
    public function getDescriptionAttribute($value)
    {
       if(empty($value)){
            return "
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos
sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
recusandae alias error harum maxime adipisci amet laborum. Perspiciatis
minima nesciunt dolorem! Officiis iure rerum voluptates a cumque velit
quibusdam sed amet tempora. Sit laborum ab, eius fugit doloribus tenetur
fugiat, temporibus enim commodi iusto libero magni deleniti quod quam
consequuntur! Commodi minima excepturi repudiandae velit hic maxime
doloremque. Quaerat provident commodi consectetur veniam similique ad
earum omnis ipsum saepe, voluptas, hic voluptates pariatur est explicabo
fugiat, dolorum eligendi quam cupiditate excepturi mollitia maiores labore
suscipit quas? Nulla, placeat. Voluptatem quaerat non architecto ab laudantium
modi minima sunt esse temporibus sint culpa, recusandae aliquam numquam
totam ratione voluptas quod exercitationem fuga. Possimus quis earum veniam
quasi aliquam eligendi, placeat qui corporis!
            ";
        }else{
            return $value;
        }
    }

//    protected $with ='owner.profile';

    //relations
    public function owner() {
        return $this->belongsTo(Owner::class,'owner_id');
    }

    public function categories() {
        return $this->hasMany(Category::class,'factory_id');
    }
    public function F_permissions()
    {
        return $this->hasOne(FactoryPermissions::class,"factory_id");
    }
    public function BuyersOrderedFromMyFactory(){
        return $this->belongsToMany(Buyer::class,'orders','factory_id','buyer_id')
            ->using(Order::class)
            ->as('order')
            ->withPivot('id as order_id','status','comment','orderDate','requiredDate','shippedDate')
            ->withTimestamps();
    }
}
