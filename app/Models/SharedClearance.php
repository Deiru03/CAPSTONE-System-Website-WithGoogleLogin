<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clearance;
use App\Models\User;

class SharedClearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'clearance_id',
        'user_id',
    ];

    /**
     * Get the clearance associated with the shared clearance.
     */
    public function clearance()
    {
        return $this->belongsTo(Clearance::class, 'clearance_id');
    }

    /**
     * Get the user associated with the shared clearance.
     */
    public function userClearances()
    {
        return $this->hasMany(UserClearance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the uploaded clearances associated with the shared clearance.
     */
    public function uploadedClearances()
    {
        return $this->hasMany(UploadedClearance::class, 'shared_clearance_id');
    }

    public function showClearances()
    {
        // Fetch all shared clearances
        $sharedClearances = SharedClearance::all();

        // Pass the shared clearances to the view
        return view('admin.views.clearances', compact('sharedClearances'));
    }
}
