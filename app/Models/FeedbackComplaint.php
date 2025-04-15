<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackComplaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Nama pengirim feedback
        'email', // Email pengirim
        'type', // Feedback atau Complaint
        'description', // Isi feedback atau keluhan
        'status', // Status (Open, In Progress, Resolved, Closed)
    ];
}
