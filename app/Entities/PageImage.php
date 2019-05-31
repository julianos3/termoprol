<?php

namespace AgenciaS3\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PageImage.
 *
 * @package namespace AgenciaS3\Entities;
 */
class PageImage extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'image',
        'label',
        'label',
        'order',
        'cover'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

}
