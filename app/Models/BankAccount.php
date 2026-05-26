<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_user_id',
        'account_number',
        'agency',
        'balance',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(BankUser::class, 'bank_user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'bank_account_id');
    }

    public function caixinha()
    {
        return $this->hasOne(Caixinha::class, 'bank_account_id');
    }
}
