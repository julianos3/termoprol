<?php

namespace AgenciaS3\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class LandingPageProductValidator.
 *
 * @package namespace AgenciaS3\Validators;
 */
class LandingPageProductValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'landing_page_id' => 'required|exists:landing_pages,id',
            'name' => 'required|min:3|max:191',
            'active' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'landing_page_id' => 'required|exists:landing_pages,id',
            'name' => 'required|min:3|max:191',
            'active' => 'required'
        ],
    ];
}
