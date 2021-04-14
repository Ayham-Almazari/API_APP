<?php

namespace App\Http\Livewire;

use App\Models\Owner;
use Livewire\Component;

class Counter extends Component
{

//    public $count = "sss";
    public $search = '';



    public function render()
    {
        return view('livewire.counter',[
            'users' => Owner::where('username', 'LIKE' ,"%$this->search%")->with('profile')->limit(5)->get(),
        ]);
    }
}
