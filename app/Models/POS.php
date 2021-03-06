<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POS extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','pro_name','pro_quantity','product_price','sub_total'];

    protected $table = 'pos';
}
