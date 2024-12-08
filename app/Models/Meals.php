<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meals extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unit_id',
        'food_id',
        'unit',
        'ate_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit_id'=>'integer',
        'food_id'=>'integer',
        'unit'=>'integer',
        'ate_at' => 'datetime',
    ];

    public function unidade()
    {
        return $this->belongsTo(Units::class,'unit_id');
    }
    public function foods()
    {
        return $this->belongsTo(Foods::class,'food_id');
    }

}
