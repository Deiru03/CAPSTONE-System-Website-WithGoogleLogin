<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedClearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'shared_clearance_id',
        'requirement_id',
        'user_id',
        'file_path',
        'status'
    ];
    
    /**
     * Get the shared clearance associated with the upload.
     */
    public function sharedClearance()
    {
        return $this->belongsTo(SharedClearance::class, 'shared_clearance_id');
    }

    /**
     * Get the requirement associated with the upload.
     */
    public function requirement()
    {
        return $this->belongsTo(ClearanceRequirement::class, 'requirement_id');
    }

    /**
     * Get the user who uploaded the file.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function feedback()
    {
        return $this->hasMany(ClearanceFeedback::class, 'requirement_id', 'requirement_id');
    }
}
