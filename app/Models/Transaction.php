<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'bank_transactions';

    protected $fillable = [
        'bank_account_id',
        'type',
        'description',
        'amount',
    ];

    public function account()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }
}
