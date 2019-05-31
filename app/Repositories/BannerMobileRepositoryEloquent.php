<?php

namespace AgenciaS3\Repositories;

use AgenciaS3\Entities\BannerMobile;
use AgenciaS3\Validators\BannerMobileValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class BannerMobileRepositoryEloquent.
 *
 * @package namespace AgenciaS3\Repositories;
 */
class BannerMobileRepositoryEloquent extends BaseRepository implements BannerMobileRepository, CacheableInterface
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
        return BannerMobile::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return BannerMobileValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
