<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InboundItems extends Model
{
    use HasFactory;
    protected $fillable =  ['input_date', 'user', 'invoice_code', 'item_code', 'item_name', 'unit', 'supplier_code', 'supplier_name', 'purchase_price', 'quantity', 'total_price'];

}
