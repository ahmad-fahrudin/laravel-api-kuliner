<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'keranjangs';

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
