<?php

namespace App\Jobs;

use App\Http\Traits\Responses_Trait;
use App\Models\BuyerOrder;
use App\Models\OwnerOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateBuyer__OWNEROrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Responses_Trait;

    private $user;
    private $user_profile;
    private $base64;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$user_profile,$base64)
    {
        $this->onQueue('Update-Orders');
        $this->user=$user;
        $this->user_profile=$user_profile;
        $this->base64=$base64;
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
            $Order = ($this->user->isBuyer() && !$this->user->isAdmin() ? new BuyerOrder : new OwnerOrder())
                ->select('picture')->where($this->user->getJWTCustomClaims()['role']."_id",$this->user->id)->take(1)->get();
            $update_image = $this->update_image($Order[0]->picture,
                'factories_orders/users-images/'.$this->user->getJWTCustomClaims()['role'].'s',
                $this->base64
            );
            $this->user_profile['picture'] = $update_image ? $update_image->uploaded_image : null;
        ($this->user->isBuyer() && !$this->user->isAdmin() ? new BuyerOrder : new OwnerOrder())->where(
            $this->user->getJWTCustomClaims()['role'].'_id', $this->user->id)
            ->update($this->user_profile);
    }
}
