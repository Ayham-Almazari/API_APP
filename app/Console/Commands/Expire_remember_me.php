<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Buyer;
use App\Models\Owner;
use Illuminate\Console\Command;

class Expire_remember_me extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:transformation_remember_me_to_0';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'expire users every 24 hours to login again';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $buyers=  Buyer::where('remember_me', 1)->get();
      $buyers->toQuery()->update([
          'remember_me'=>0
      ]);
      $owners=  Owner::where('remember_me', 1)->get();
        $owners->toQuery()->update([
          'remember_me'=>0
      ]);
      $admins=  Admin::where('remember_me', 1)->get();
        $admins->toQuery()->update([
          'remember_me'=>0
      ]);

    }
}
