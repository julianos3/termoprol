<?php

namespace AgenciaS3\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LandingPage.
 *
 * @package namespace AgenciaS3\Entities;
 */
class LandingPage extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'banner',
        'description',
        'avatar_1_6',
        'avatar_1_1',
        'video',
        'email',
        'active',
        'seo_keywords',
        'seo_description',
        'seo_link'
    ];

    public function products()
    {
        return $this->hasMany(LandingPageProduct::class);
    }

    public function contacts()
    {
        return $this->hasMany(LandingPageContact::class);
    }

}
