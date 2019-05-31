<?php

namespace AgenciaS3\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class BannerMobileValidator.
 *
 * @package namespace AgenciaS3\Validators;
 */
class BannerMobileValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|min:3|max:255',
            'image' => 'required',
            'target_blank' => 'required',
            'active' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|min:3|max:255',
            'target_blank' => 'required',
            'active' => 'required'
        ],
    ];
}
