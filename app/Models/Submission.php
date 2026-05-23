<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_name',
        'challenge_id',
        'submitted_flag',
        'is_correct',
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
