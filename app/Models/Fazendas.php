<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Fazendas.
 *
 * @package namespace App\Models;
 */
class Fazendas extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FAZENDA_NOME',
        'PASTO_ID'
    ];

    /**
     * Get all of the piquetes for the Fazendas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function piquetes()
    {
        return $this->hasMany(FazendasPiquetes::class, 'FAZENDA_ID', 'id');
    }

    /**
     * Get the pasto that owns the Fazendas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pasto()
    {
        return $this->belongsTo(Pastos::class, 'PASTO_ID', 'id');
    }

}
