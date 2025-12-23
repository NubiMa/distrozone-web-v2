<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name', 'account_number', 'account_holder_name',
        'is_active', 'sort_order'
    ];

    protected $casts = ['is_active' => 'boolean'];
}
