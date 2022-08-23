<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FazendasPiquetes.
 *
 * @package namespace App\Models;
 */
class FazendasPiquetes extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FAZENDA_ID',
        'PIQUETE_INDEX',
        'PIQUETE_DESCRICAO',
        'PIQUETE_OCUPADO',
        'PIQUETE_ULTIMA_DESOCUPACAO',
        'PIQUETE_ULTIMA_OCUPACAO'
    ];

    /**
     * Get the fazenda that owns the FazendasPiquetes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fazenda()
    {
        return $this->belongsTo(Fazendas::class, 'FAZENDA_ID', 'id');
    }

}
