<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'item_code',
        'name',
        'description',
        'current_stock',
        'reorder_level',
        'unit_price',
    ];

    /**
     * Get the used parts for the inventory item.
     */
    public function usedParts()
    {
        return $this->hasMany(UsedPart::class);
    }

    /**
     * Get the inventory transactions for the inventory item.
     */
    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    /**
     * Get the logistics items for the inventory item.
     */
    public function logisticsItems()
    {
        return $this->hasMany(LogisticsItem::class);
    }
}

