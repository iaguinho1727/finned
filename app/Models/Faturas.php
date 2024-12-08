<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faturas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pago_em',
        'expires_at',
        'bank_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'paid'=>'boolean',
        'expires_at' => 'date',
    ];

    public function movements(): BelongsToMany
    {
        return $this->belongsToMany(Movement::class,'faturas_movements','fatura_id','movement_id');
    }
    public function banks()
    {
        return $this->belongsTo(Banks::class,'bank_id');
    }
}
