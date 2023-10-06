<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout("layouts.auth")]
class Auth extends Component
{

    public $action = "login";

    public function render()
    {
        return view('livewire.auth.auth');
    }


    public function changeTheAction($name){

        $this->action = $name;
    }
}
