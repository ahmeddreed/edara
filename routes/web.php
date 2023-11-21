<?php
use App\Livewire\Home;
use App\Livewire\Invoice;
use App\Livewire\Profile;
use App\Livewire\Auth\login;
use App\Livewire\ItemDetails;
use App\Http\Controllers\logout;
use App\Livewire\Auth\CustomerLogin;
use App\Livewire\Auth\CustomerLogout;
use App\Livewire\Dashboard\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\RolesTable;
use App\Livewire\Dashboard\StaffTable;
use App\Livewire\Auth\CustomerRegister;
use App\Livewire\Dashboard\StaffProfile;
use App\Livewire\Dashboard\CustomerTable;

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
Route::get("/detaile/{id}",ItemDetails::class)->name("detaile");
// Route::get("/Authentication",Auth::class)->name("Authentication");

Route::get("/customerRegister",CustomerRegister::class)->name("customerRegister");
Route::get("/customerLogin",CustomerLogin::class)->name("customerLogin");
Route::get("/login",login::class)->name("login");
Route::get("/customerLogout",[logout::class,"logoutCustomer"])->name("customerLogout");


//Dashboard route
Route::get("Dashboard",Dashboard::class)->name("dashboard")->middleware("auth");
Route::get("rolesTable",RolesTable::class)->name("rolesTable");
Route::get("staffTable",StaffTable::class)->name("staffTable");
Route::get("staff-profile",StaffProfile::class)->name("staff.profile");
Route::get("customer-table",CustomerTable::class)->name("customerTable");
