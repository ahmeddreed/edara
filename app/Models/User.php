<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Invoice;
use App\Models\CustomerAccount;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'role_id',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function role(){

        return $this->belongsTo(Role::class)->first();
    }

    public function customer_account(){

        return $this->hasOne(CustomerAccount::class);
    }


    public function check_invoice($inv_id){//For Delegate

        return DelegateAccount::where("user_id",$this->id)->where("invoice_id",$inv_id)->exists();
    }

    public function delegateAccount(){

        $data = null;
        $theCost = 0;
        if($this->role_id == 4){
            $data = DelegateAccount::where("user_id",$this->id)->get();
            $cost = 0;
            foreach ($data as $item) {
                $invice = Invoice::find($item->invoice_id);
                if($invice){
                    $cost += $invice->totalCost();
                }
            }

            $theCost = $cost * 0.01;
        }

        return $theCost;
    }

}
