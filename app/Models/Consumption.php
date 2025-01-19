<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consumption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'consumable_id',
        'unit_id',
        'consumable_unit_quantity',
        'hours_consumed',
        'comodo',
        'casa',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'consumable_id' => 'integer',
        'unit_id' => 'integer',
        'consumable_unit_quantity' => 'float',
        'hours_consumed'=>'float',
    ];

    public function consumable(): BelongsTo
    {
        return $this->belongsTo(Consumable::class,'consumable_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Units::class,'unit_id');
    }
}
