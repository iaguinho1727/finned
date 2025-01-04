<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'participant_id',
        'movement_date',
        'movement_type',
        'categories_id',
        'card_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'value' => 'float',
        'movement_date'=>'date',
        'participant_id' => 'integer',
        'categories_id'=>'integer',
        'card_id'=>'integer'
    ];


    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }
    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function cards()
    {
        return $this->belongsTo(Cards::class,'card_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'movements_products','movement_id','product_id');
    }

    public function faturas()
    {
        return $this->belongsToMany(Faturas::class,'faturas_movements','movement_id','fatura_id');
    }
}
