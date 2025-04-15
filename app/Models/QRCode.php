<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRCode extends Model
{
    use HasFactory;


    protected $table = 'qr_codes';

    protected $fillable = [
        'code',
        'status',
        'store_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
