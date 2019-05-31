<?php

namespace AgenciaS3\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class FormEmailValidator.
 *
 * @package namespace AgenciaS3\Validators;
 */
class FormEmailValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'form_id' => 'required|exists:forms,id',
            'email' => 'required|email|max:255'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'form_id' => 'required|exists:forms,id',
            'email' => 'required|email|max:255'
        ],
    ];
}
