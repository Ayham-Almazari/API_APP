<?php

namespace App\View\Components;

use App\Models\Buyer;
use Illuminate\View\Component;

class Buyers extends Component
{
    public $buyers;
    public $buyersCount;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->buyers= Buyer::all();
        $this->buyersCount = Buyer::count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.buyers');
    }
}
