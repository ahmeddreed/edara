<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class logout extends Controller
{
    public function logoutCustomer(){//////show all data /////////

        session()->pull("customer");
        session()->pull("customer-invoice");
        return redirect()->route("home")->with("msg_s","تم حذف البياناتك");
    }
}
