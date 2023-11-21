<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{

    #[Layout("layouts.dashboard")]

    public function render()
    {
        return view('livewire.dashboard.dashboard');
    }


    public function logout(){

        Auth::logout();
        session()->flash("msg_s","تم تسجيل الخروج بنجاح");

        $this->redirect("/");
    }
}
