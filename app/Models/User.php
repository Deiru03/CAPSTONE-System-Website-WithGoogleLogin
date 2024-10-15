<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'user_type', // Added date 09/16/2024 // Admin, Faculty
        'program', // Added date 09/16/2024 // BSIT, COMSC, etc.
        'position', // Added date 09/16/2024 // Permanent, Temporary, Part-Timer
        'units', // Added date 09/16/2024 // 3 units, 2 units, etc.
        'clearances_status', // Added date 09/16/2024 // pending, return, complete
        'last_clearance_update', // Added date 09/16/2024 // date when last clearance update was made
        'checked_by', // Added date 09/16/2024 // name of the person who checked the clearance
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
            'last_clearance_update' => 'datetime', // Cast to date
            'clearances_status' => 'string', // Cast to string (if using enum)

        ];
    }

    public function sharedClearances()
    {
        return $this->hasMany(SharedClearance::class);
    }

    public function userClearances()
    {
        return $this->hasMany(UserClearance::class);
    }

    public function uploadedClearances()
    {
        return $this->hasMany(UploadedClearance::class);
    }

    public function feedback()
    {
        return $this->hasMany(ClearanceFeedback::class);
    }
}
