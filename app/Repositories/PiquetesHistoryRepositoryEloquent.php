<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PiquetesHistoryRepository;
use App\Models\PiquetesHistory;
use App\Validators\PiquetesHistoryValidator;

/**
 * Class PiquetesHistoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PiquetesHistoryRepositoryEloquent extends BaseRepository implements PiquetesHistoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PiquetesHistory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
