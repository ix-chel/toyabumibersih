<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'specialization',
        'certification',
    ];

    /**
     * Get the user that owns the technician.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the maintenance reports for the technician.
     */
    public function maintenanceReports()
    {
        return $this->hasMany(MaintenanceReport::class);
    }
}

