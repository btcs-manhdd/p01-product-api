<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubProduct;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';
    protected $fillable = [
        'name',
        'code'
    ];
    public $timestamps = false;
    public function subProducts()
    {
        $this->hasMany(SubProduct::class, 'color_id');
    }
}