<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkHours extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'begin_date',
        'hours',
        'bussiness_hours',
        'bussiness_days'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'begin_date' => 'date',
        'hours' => 'float',
        'bussiness_hours'=>'float',
        'bussiness_days'=>'integer'
    ];
}
