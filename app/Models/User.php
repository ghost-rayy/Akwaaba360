<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'staff_number',
        'nss_number',
        'phone_number',
        'role',
        'password',
        'password_must_change',
        'status',
        'department_id',
    ];

    /**
     * Boot the model to handle cascading deletions.
     */
    protected static function booted()
    {
        static::deleting(function ($user) {
            // Automatically clean up associated administrative records
            if ($user->onboardingRecord) {
                $user->onboardingRecord->delete();
            }
            if ($user->personnelProfile) {
                $user->personnelProfile->delete();
            }
        });
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function isHrAdmin(): bool
    {
        return $this->role === 'hr_admin';
    }

    public function isHrStaff(): bool
    {
        return $this->role === 'hr_staff';
    }

    public function isPersonnel(): bool
    {
        return $this->role === 'personnel';
    }

    public function onboardingRecord()
    {
        return $this->hasOne(OnboardingRecord::class);
    }

    public function personnelProfile()
    {
        return $this->hasOne(PersonnelProfile::class);
    }

    public function isShortlisted(): bool
    {
        return $this->onboardingRecord && $this->onboardingRecord->status === 'shortlisted';
    }

    public function isEndorsed(): bool
    {
        return $this->onboardingRecord && $this->onboardingRecord->status === 'endorsed';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
