<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\pastos_periodoRepository;
use App\Models\PastosPeriodo;
use App\Validators\PastosPeriodoValidator;

/**
 * Class PastosPeriodoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PastosPeriodoRepositoryEloquent extends BaseRepository implements PastosPeriodoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PastosPeriodo::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
