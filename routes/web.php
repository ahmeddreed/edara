<?php
use App\Livewire\Home;
use App\Livewire\ItemDetails;
use App\Livewire\Profile;
use App\Livewire\Invoice;
use App\Livewire\Auth\Auth;
use App\Livewire\Auth\CustomerRegister;
use App\Livewire\Auth\CustomerLogin;
use App\Livewire\Auth\CustomerLogout;
use App\Http\Controllers\logout;
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
Route::get("/invoice",Invoice::class)->name("invoice");
Route::get("/profile",Profile::class)->name("profile")->middleware("customerAuth");
Route::get("/Authentication",Auth::class)->name("Authentication");
Route::get("/customerRegister",CustomerRegister::class)->name("customerRegister");
Route::get("/customerLogin",CustomerLogin::class)->name("customerLogin");
// Route::get("/customerLogout",CustomerLogout::class)->name("customerLogout");
Route::get("/detaile/{id}",ItemDetails::class)->name("detaile");
Route::get("/customerLogout",[logout::class,"logoutCustomer"])->name("customerLogout");
// Route::get('/', function () {
//     return view('livewire.home');
// });
