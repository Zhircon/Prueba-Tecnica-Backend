<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    //
    protected $table = 'product';
    protected $fillable = [
        'name',
        'product_type_id'
    ];
    protected $hidden =[
        'created_at',
        'updated_at'
    ];
    public function productType() :BelongsTo{
        return $this->belongsTo('App\Models\ProductType');
    }
}
