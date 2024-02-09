<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IMF extends Model
{
    use HasFactory;

    protected $fillable = [
        "operation_type",
        "user_id",
        "customer_id",
        "old_number",
        "new_number",
        "number",
        "note",
    ];


    public function customer(){

        return $this->belongsTo(Customer::class)->first();
    }


    public function user(){

        return $this->belongsTo(User::class)->first();
    }
}
