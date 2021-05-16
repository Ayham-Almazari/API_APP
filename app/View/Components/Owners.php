<?php

namespace App\View\Components;

use App\Models\Owner;
use Illuminate\View\Component;

class Owners extends Component
{
     public  $owners;
     public  $ownersCount;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->owners=Owner::all();
        $this->ownersCount=Owner::count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.owners');
    }
}
