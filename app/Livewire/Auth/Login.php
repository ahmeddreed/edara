<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login extends Component
{

    #[Layout("layouts.auth")]
    public $email;
    public $password;
    public function render()
    {

        return view('livewire.auth.login');
    }


    public function login(){

        $this->validate([
            "email"=>"required|email",
            "password"=>"required"
        ],[
            "email.required"=>"الايميل مطلوب",
            "email.email"=>"الايميل غير صحيح",
            "password.required"=>"الرمز السري مطلوب",
        ]);


        $user = User::all()->where("email" ,'=', $this->email)->first();//get Data of user
        $user_c = User::all()->where("email" ,'=', $this->email)->count();//

        if ($user_c > 0 ){//check email
            if(Hash::check($this->password, $user->password)){//check password
               Auth::attempt([
                "email"=> $this->email,
                "password"=>$this->password,
               ]);//login is successfuly

               $this->redirect("Dashboard");

            }else{//the password in invalid
                session()->flash("msg_e", "عذرا الرمز السري خطا");
            }
        }else{//the email in invalid
            session()->flash("msg_e", "عذرا الايميل خطا");
        }

    }
}
