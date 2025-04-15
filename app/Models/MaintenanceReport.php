<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'user_id',
        'status',
        'notes',
        'performed_at',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(MaintenanceReportPhoto::class);
    }

    public function partsUsed()
    {
        return $this->hasMany(MaintenancePartUsed::class);
    }
} 