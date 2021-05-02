<?php

namespace App\Jobs;

use App\Http\Traits\Responses_Trait;
use App\Models\OrderDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateProductsOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Responses_Trait;

    private $product;
    private $base64;
    private $data;
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product , $data ,$base64)
    {
        $this->onQueue('Update-Orders');
        $this->product=$product;
        $this->base64=$base64;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orderdetails=OrderDetails::select('product_picture')->where('product_id',$this->product->id)->take(1)->get();
        $update_image= $this->update_image($orderdetails[0]->product_picture,'factories_orders/product-images',$this->base64);
        $this->data['product_picture']= $update_image ? $update_image->uploaded_image :null;
        OrderDetails::where('product_id',$this->product->id)->update(\Arr::add(\Arr::only($this->data,['product_name','product_picture']),'category',$this->product->under_category->category_name));
    }

}
