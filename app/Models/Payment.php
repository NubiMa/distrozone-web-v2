<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'payment_method', 'amount',
        'proof_image_path', 'proof_uploaded_at',
        'sender_bank_name', 'sender_account_name', 'sender_account_number',
        'status', 'verified_by', 'verified_at', 'rejection_reason'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'proof_uploaded_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}