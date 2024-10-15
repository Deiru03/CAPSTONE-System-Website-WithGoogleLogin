<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearanceRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'clearance_id',
        'requirement',
    ];

    public function clearance()
    {
        return $this->belongsTo(Clearance::class, 'clearance_id');
    }

    protected static function booted()
    {
        static::created(function ($requirement) {
            $requirement->clearance->increment('number_of_requirements');
        });

        static::deleted(function ($requirement) {
            $requirement->clearance->decrement('number_of_requirements');
        });
    }
    /**
     * Get the uploaded clearances associated with the shared clearance.
     */
    public function uploadedClearances()
    {
        return $this->hasMany(UploadedClearance::class, 'requirement_id');
    }

    public function feedback()
    {
        return $this->hasMany(ClearanceFeedback::class, 'requirement_id');
    }
}
