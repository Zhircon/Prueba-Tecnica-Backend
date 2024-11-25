<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    protected $table = 'product_type';
    protected $fillable = [
        'description'
    ];
    protected $hidden =[
        'created_at',
        'updated_at'
    ];
    public function products():HasMany{
        return $this->hasMany('App\Models\Product');
    }
}
