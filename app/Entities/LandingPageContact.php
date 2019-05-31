<?php

namespace AgenciaS3\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LandingPageContact.
 *
 * @package namespace AgenciaS3\Entities;
 */
class LandingPageContact extends Model implements Transformable
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
        'email',
        'phone',
        'message',
        'view',
        'session_id',
        'ip'
    ];

    public function landingPage()
    {
        return $this->belongsTo(LandingPage::class, 'landing_page_id');
    }


}
