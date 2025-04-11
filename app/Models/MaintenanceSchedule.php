<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'filter_id',
        'scheduled_date',
        'maintenance_type',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_date' => 'date',
    ];

    /**
     * Get the filter that owns the maintenance schedule.
     */
    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }

    /**
     * Get the maintenance report for the schedule.
     */
    public function maintenanceReport()
    {
        return $this->hasOne(MaintenanceReport::class, 'schedule_id');
    }
}

