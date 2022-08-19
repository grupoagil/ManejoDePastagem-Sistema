<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Pastos.
 *
 * @package namespace App\Models;
 */
class Pastos extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PASTO_NOME',
        'PASTO_DATA_INICIAL',
        'PASTO_DATA_FINAL',
        'PASTO_DESCRICAO'
    ];

}
