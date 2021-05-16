<?php

namespace App\View\Components;

use App\Models\Admin;
use Illuminate\View\Component;

class Admins extends Component
{
    public $AdminsCount;
    public $Admins;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->AdminsCount=Admin::count();
        $this->Admins=Admin::all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admins');
    }
}
