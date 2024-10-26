<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'requirement_id',
        'uploaded_clearance_id',
        'title',
        'transaction_type',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requirement()
    {
        return $this->belongsTo(ClearanceRequirement::class);
    }

    public function uploadedClearance()
    {
        return $this->belongsTo(UploadedClearance::class);
    }
}
