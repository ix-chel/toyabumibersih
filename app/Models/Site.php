<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'name',
        'address',
        'contact_person',
        'phone',
    ];

    /**
     * Get the client that owns the site.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the filters for the site.
     */
    public function filters()
    {
        return $this->hasMany(Filter::class);
    }

    /**
     * Get the water usage reports for the site.
     */
    public function waterUsageReports()
    {
        return $this->hasMany(WaterUsageReport::class);
    }
}

