<?php

namespace AgenciaS3\Repositories;

use AgenciaS3\Entities\Banner;
use AgenciaS3\Validators\BannerValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class BannerRepositoryEloquent.
 *
 * @package namespace AgenciaS3\Repositories;
 */
class BannerRepositoryEloquent extends BaseRepository implements BannerRepository, CacheableInterface
{

    use CacheableRepository;

    public function showStore($limit = null)
    {
        $dados = $this->scopeQuery(function ($query) {
            return $query->where('active', 'y')->orderByRaw('RAND()');
        });

        if (isset($limit)) {
            $dados = $dados->paginate($limit);
        }

        if ($limit == 1) {
            return $dados->first();
        }

        return $dados->all();
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Banner::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return BannerValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
