<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'phone',
    ];

    protected $hidden = [
        'password',
    ];

    public function accounts()
    {
        return $this->hasMany(BankAccount::class);
    }
}
