<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnboardingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'shortlisted_at',
        'endorsed_at',
    ];

    protected $casts = [
        'shortlisted_at' => 'datetime',
        'endorsed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
