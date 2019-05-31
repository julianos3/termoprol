<?php

namespace AgenciaS3\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LandingPageProduct.
 *
 * @package namespace AgenciaS3\Entities;
 */
class LandingPageProduct extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'landing_page_id',
        'name',
        'description',
        'image',
        'active',
        'order'
    ];

    public function landingPage()
    {
        return $this->belongsTo(LandingPage::class, 'landing_page_id');
    }

}
