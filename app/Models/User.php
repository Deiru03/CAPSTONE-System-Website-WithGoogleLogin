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
        'position', // Added date 09/16/2024 // Permanent, Temporary, Part-Timer //Modified date 11/16/2024 // Permanent-FullTime, Permanent-PartTime, Temporary, Part-Timer, Dean, Program-Head
        'units', // Added date 09/16/2024 // 3 units, 2 units, etc.
        'clearances_status', // Added date 09/16/2024 // pending, return, complete
        'last_clearance_update', // Added date 09/16/2024 // date when last clearance update was made
        'checked_by', // Added date 10/19/2024 // department id
        'department_id', // Added date 10/19/2024 // department id
        'program_id', // Added date 10/19/2024 // program id
        'admin_id_registered', // Added date 10/30/2024 // admin id registered
        'campus_id', // Added date 11/09/2024 // campus id
        'program_head_id', // Added date 11/09/2024 // program head id
        'dean_id', // Added date 11/09/2024 // dean id
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

    // Available roles for switching user type
    public function availableRoles()
    {
        $roles = [];
    
        if ($this->program_head_id) {
            $roles[] = 'Program-Head';
        }
    
        if ($this->dean_id) {
            $roles[] = 'Dean';
        }
    
        if ($this->admin_id_registered) {
            $roles[] = 'Admin';
        }
    
        else {
            $roles[] = 'Faculty';
        }
    
        return $roles;
    }
    
    public function switchRole($newRole)
    {
        $this->update(['user_type' => $newRole]);
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class, 'admin_user_id', 'user_id');
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

    public function subPrograms()
    {
        return $this->hasMany(SubProgram::class);
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
    
    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}
