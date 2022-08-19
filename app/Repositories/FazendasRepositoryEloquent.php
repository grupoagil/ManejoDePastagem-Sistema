<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\fazendasRepository;
use App\Models\Fazendas;
use App\Validators\FazendasValidator;

/**
 * Class FazendasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FazendasRepositoryEloquent extends BaseRepository implements FazendasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Fazendas::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
