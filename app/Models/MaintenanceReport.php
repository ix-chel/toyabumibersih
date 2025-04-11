<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'schedule_id',
        'technician_id',
        'service_date',
        'findings',
        'actions_taken',
        'recommendations',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'service_date' => 'datetime',
    ];

    /**
     * Get the maintenance schedule that owns the report.
     */
    public function maintenanceSchedule()
    {
        return $this->belongsTo(MaintenanceSchedule::class, 'schedule_id');
    }

    /**
     * Get the technician that owns the report.
     */
    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    /**
     * Get the used parts for the report.
     */
    public function usedParts()
    {
        return $this->hasMany(UsedPart::class, 'report_id');
    }

    /**
     * Get the invoice items for the report.
     */
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'report_id');
    }
}

