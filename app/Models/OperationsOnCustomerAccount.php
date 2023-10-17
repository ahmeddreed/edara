<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationsOnCustomerAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        "customer_account_id",
        "pay",
        "old_number",
        "new_number",
        "user_id",
      ];
}
