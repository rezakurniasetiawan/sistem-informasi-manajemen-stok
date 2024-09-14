<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdSupplier extends Model
{
    use HasFactory;
    protected $fillable =  ['created_mdsupplier','id_user','code_mdsupplier', 'name_mdsupplier', 'address_mdsupplier', 'email_mdsupplier', 'phone_mdsupplier'];
}
