<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukAPI extends Model
{
    //
    use HasFactory;
    protected $table = 'produkapi';
    protected $fillable = [
        'name',
        'category',
        'stok',
        'price',
        'image',
        'description',
    ];
}
