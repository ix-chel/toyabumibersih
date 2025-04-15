<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'serial_number',
        'status',
    ];

    public function maintenanceReports()
    {
        return $this->hasMany(MaintenanceReport::class);
    }
} 