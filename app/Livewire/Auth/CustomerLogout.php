<?php

namespace App\Livewire\Auth;

use App\Livewire\Home;
use Livewire\Component;

class CustomerLogout extends Component
{
    public function render()
    {

        $this->logoutCustomer();
    }



    public function logoutCustomer(){

        session()->pull("customer");
        session()->pull("customer-invoice");
        $this->redirect('/');
    }
}
