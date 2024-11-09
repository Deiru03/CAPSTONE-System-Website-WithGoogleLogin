<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable //implements MustVerifyEmail
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
        'profile_picture', // Added date 10/18/2024 // profile picture
        'user_type', // Added date 09/16/2024 // Admin, Faculty
        'program', // Added date 09/16/2024 // BSIT, COMSC, etc.
        'position', // Added date 09/16/2024 // Permanent, Temporary, Part-Timer
        'units', // Added date 09/16/2024 // 3 units, 2 units, etc.
        'clearances_status', // Added date 09/16/2024 // pending, return, complete
        'last_clearance_update', // Added date 09/16/2024 // date when last clearance update was made
        'checked_by', // Added date 10/19/2024 // department id
        'department_id', // Added date 10/19/2024 // department id
        'program_id', // Added date 10/19/2024 // program id
        'admin_id_registered', // Added date 10/30/2024 // admin id registered
        'campus_id', // Added date 11/09/2024 // campus id
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

    public function clearances()
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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function college()
    {
        return $this->belongsTo(Department::class);
    }

    public function managedFaculty()
    {
        return $this->belongsToMany(User::class, 'admin_faculty', 'admin_id', 'faculty_id');
    }

    public function managingAdmins()
    {
        return $this->belongsToMany(User::class, 'admin_faculty', 'faculty_id', 'admin_id');
    }
}
