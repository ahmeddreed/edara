<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout("layouts.main")]

class Home extends Component
{
    public function render()
    {
        return view('livewire.home');
    }
}
