<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\pastosRepository;
use App\Models\Pastos;
use App\Validators\PastosValidator;

/**
 * Class PastosRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PastosRepositoryEloquent extends BaseRepository implements PastosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pastos::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
