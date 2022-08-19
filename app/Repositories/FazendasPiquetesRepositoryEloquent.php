<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\fazendas_piquetesRepository;
use App\Models\FazendasPiquetes;
use App\Validators\FazendasPiquetesValidator;

/**
 * Class FazendasPiquetesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FazendasPiquetesRepositoryEloquent extends BaseRepository implements FazendasPiquetesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FazendasPiquetes::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
