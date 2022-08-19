<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PastosPeriodo.
 *
 * @package namespace App\Models;
 */
class PastosPeriodo extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PASTO_ID',
        'PASTO_PERIODO_NOME'
    ];

}
