<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenancePartUsed extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'part_name',
        'quantity',
    ];

    public function report()
    {
        return $this->belongsTo(MaintenanceReport::class, 'report_id');
    }
} 