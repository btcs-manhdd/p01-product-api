<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubProduct;

class Size extends Model
{
    use HasFactory;

    protected $table = 'sizes';
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;
    public function subProducts()
    {
        $this->hasMany(SubProduct::class, 'size_id');
    }
}