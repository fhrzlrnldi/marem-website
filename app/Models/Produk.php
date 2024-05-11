<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $guarded = 
    [
        "id"
    ];

    // protected $fillable = [
    //     'name',
    //     'harga',
    //     'gambar_produk',
    //     'status',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    
}
