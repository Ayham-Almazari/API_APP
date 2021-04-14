<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Post extends Component
{
    public $load = 1;


    public function inc()
    {
       $this->load++;
    }
    public function dec()
    {
        $this->load--;
    }
    public function render()
    {
        return view('livewire.post');
    }
}
