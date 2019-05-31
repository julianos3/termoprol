<?php

namespace AgenciaS3\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class LandingPageContactValidator.
 *
 * @package namespace AgenciaS3\Validators;
 */
class LandingPageContactValidator extends LaravelValidator
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
            'phone' => 'required|min:3|max:191',
            'email' => 'required|email',
            'view' => 'required',
            'session_id' => 'required',
            'ip' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'landing_page_id' => 'required|exists:landing_pages,id',
            'name' => 'required|min:3|max:191',
            'phone' => 'required|min:3|max:191',
            'email' => 'required|email',
            'view' => 'required',
            'session_id' => 'required',
            'ip' => 'required'
        ],
    ];
}
