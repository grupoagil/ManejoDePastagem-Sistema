<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PiquetesHistory.
 *
 * @package namespace App\Models;
 */
class PiquetesHistory extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PIQUETE_ID',
        'PIQUETE_OP',
        'PIQUETE_TIME',
        'USER_ID'
    ];

    /**
     * Get the user that owns the PiquetesHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'USER_ID', 'id');
    }

    /**
     * Get the piquete that owns the PiquetesHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function piquete()
    {
        return $this->belongsTo(FazendasPiquetes::class, 'PIQUETE_ID', 'id');
    }
}
