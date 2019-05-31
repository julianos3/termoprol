<?php

namespace AgenciaS3\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class LandingPageValidator.
 *
 * @package namespace AgenciaS3\Validators;
 */
class LandingPageValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|min:3|max:191',
            'description' => 'required',
            'active' => 'required',
            'seo_link' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|min:3|max:191',
            'description' => 'required',
            'active' => 'required',
            'seo_link' => 'required'
        ],
    ];
}
