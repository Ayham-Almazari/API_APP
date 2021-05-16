<?php

namespace App\View\Components;

use App\Models\Factory;
use Illuminate\View\Component;

class Factories extends Component
{
    public $factoriesCount;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->factoriesCount=Factory::count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.factories');
    }
}
