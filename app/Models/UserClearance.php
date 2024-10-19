<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'shared_clearance_id',
        'user_id',
        'is_active',
    ];

    /**
     * Get the shared clearance associated with the user clearance.
     */
    public function sharedClearance()
    {
        return $this->belongsTo(SharedClearance::class, 'shared_clearance_id');
    }

    /**
     * Get the user associated with the user clearance.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function uploadedClearances()
    {
        return $this->hasMany(UploadedClearance::class, 'shared_clearance_id', 'shared_clearance_id', 'user_clearance_id');
    }


      /**
     * Retrieve the UploadedClearance for a specific requirement.
     *
     * @param int $requirementId
     * @return \App\Models\UploadedClearance|null
     */
    public function uploadedClearanceFor($requirementId)
    {
        return $this->uploadedClearances()
                    ->where('requirement_id', $requirementId)
                    ->where('user_id', $this->user_id)
                    ->first();
    }
}
