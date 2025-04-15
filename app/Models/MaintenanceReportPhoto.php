<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceReportPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'file_path',
    ];

    public function report()
    {
        return $this->belongsTo(MaintenanceReport::class, 'report_id');
    }
} 