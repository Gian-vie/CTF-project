<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caixinha extends Model
{
    use HasFactory;

    protected $table = 'bank_caixinhas';

    protected $fillable = [
        'bank_account_id',
        'balance',
        'total_yield',
    ];

    public function account()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }
}
