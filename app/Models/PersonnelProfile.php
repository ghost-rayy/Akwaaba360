<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonnelProfile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'surname',
        'gender',
        'residence',
        'university',
        'program',
        'region',
        'academic_year',
        'posting_letter_path',
        'confirmed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
