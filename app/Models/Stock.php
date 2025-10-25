<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'input_date',
        'user',
        'invoice_code',
        'item_code',
        'item_name',
        'unit',
        'supplier_code',
        'supplier_name',
        'purchase_price',
        'quantity',
        'quantity_out',
        'total_price',
        'total_price_after',
        'type',
    ];

    protected $casts = [
        'input_date' => 'datetime',
        'purchase_price' => 'integer',
        'quantity' => 'integer',
        'quantity_out' => 'integer',
        'total_price' => 'integer',
        'total_price_after' => 'integer',
    ];
}
