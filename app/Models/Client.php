<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_name',
        'contact_person',
        'email',
        'phone',
        'address',
    ];

    /**
     * Get the sites for the client.
     */
    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    /**
     * Get the invoices for the client.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the water usage reports for the client.
     */
    public function waterUsageReports()
    {
        return $this->hasMany(WaterUsageReport::class);
    }
}

