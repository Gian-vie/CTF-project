<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'flag',
        'points',
        'category',
    ];

    protected $hidden = [
        'flag',
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
