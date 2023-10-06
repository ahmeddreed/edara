<?php
use App\Livewire\Home;
use App\Livewire\ItemDetails;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Auth;
use App\Livewire\Auth\CustomerLogin;
use App\Livewire\Auth\CustomerRegister;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/",Home::class)->name("home");
Route::get("/login",Auth::class)->name("login");
Route::get("/customerLogin",CustomerLogin::class)->name("customerLogin");
Route::get("/customerRegister",CustomerRegister::class)->name("CustomerRegister");
Route::get("/detaile/{id}",ItemDetails::class)->name("detaile");

// Route::get('/', function () {
//     return view('livewire.home');
// });
