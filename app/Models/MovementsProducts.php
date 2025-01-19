<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class MovementsProducts extends Model
{
    protected $table='movements_products';

    protected $fillable=['movement_id','product_id','unit_id','quantity','total'];



    protected $casts=[
        'movement_id'=>'integer',
        'product_id'=>'integer',
        'unit_id'=>'integer',
        'quantity'=>'float',
        'total'=>'float',
    ];

    public function movements()
    {
        return $this->belongsTo(Movement::class,'movement_id');
    }
    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function units()
    {
        return $this->belongsTo(Units::class,'unit_id');
    }



}
