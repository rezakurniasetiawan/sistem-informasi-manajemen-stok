<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdGoods extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_mdgoods',
        'id_user',
        'code_mdgoods',
        'name_mdgoods',
        'idcategory_mdgoods',
        'idunit_mdgoods',
        'purchase_price_mdgoods',
        'selling_price_mdgoods',
        'idsupplier_mdgoods',
        'code_supplier_mdgoods',
        'stock_mdgoods'
    ];
}
