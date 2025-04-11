<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'site_id',
        'serial_number',
        'model',
        'installation_date',
        'warranty_expiry',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'installation_date' => 'date',
        'warranty_expiry' => 'date',
    ];

    /**
     * Get the site that owns the filter.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the maintenance schedules for the filter.
     */
    public function maintenanceSchedules()
    {
        return $this->hasMany(MaintenanceSchedule::class);
    }
}

