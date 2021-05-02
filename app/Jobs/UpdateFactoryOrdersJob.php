<?php

namespace App\Jobs;

use App\Http\Traits\Responses_Trait;
use App\Models\FactoryOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Batchable;

class UpdateFactoryOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,Responses_Trait;
    private $factory_id;
    private $logo;
    /**
     * Create a new job instance.
     *
     * @param $factory_id
     * @param $logo
     */
    public function __construct($factory_id, $logo)
    {
        $this->onQueue('Update-Orders');
        $this->factory_id=$factory_id;
        $this->logo=$logo;
    }
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orderfactory=FactoryOrder::select('logo')->where('factory_id',$this->factory_id)->take(1)->get();
        $update_image= $this->update_image($orderfactory[0]->logo,'factories_orders/logos',$this->logo);
        $update_image= $update_image ? $update_image->uploaded_image :null;
        FactoryOrder::where('factory_id',$this->factory_id)->update(['logo'=>$update_image]);

    }
}
