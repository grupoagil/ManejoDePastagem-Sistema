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
        'PASTO_PERIODO_NOME',
        'PASTO_DATA_INICIAL',
        'PASTO_DATA_FINAL',
        'PASTO_ID'
    ];

    /**
     * Get the pasto that owns the PastosPeriodo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pasto()
    {
        return $this->belongsTo(Pastos::class, 'PASTO_ID', 'id');
    }

}
