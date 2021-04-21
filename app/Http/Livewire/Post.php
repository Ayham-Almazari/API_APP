<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Post extends Component
{
    public int $load =10;


    public function inc()
    {
         $this->load=$this->load+1;
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
