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
        'PASTO_TIPO'
    ];

    /**
     * Get all of the fazendas for the Pastos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fazendas()
    {
        return $this->hasMany(Fazendas::class, 'PASTO_ID', 'id');
    }

}
