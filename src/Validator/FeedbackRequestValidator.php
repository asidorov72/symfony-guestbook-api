<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3.4.2020 г.
 * Time: 17:32
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Annotation
 */
class FeedbackRequestValidator
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($array)
    {
        $errors = [];

        $emailConstraint = new Assert\Email();
        // all constraint "options" can be set this way
        $emailConstraint->message = 'Invalid email address';

        // use the validator to validate the value
        $errors[] = $this->validator->validate(
            $array['email'],
            $emailConstraint
        );

        if (empty($array['email'])) {
            $errors[] = 'The field "email" is required.';
        }

        if (empty($array['message'])) {
            $errors[] = 'The field "message" is required.';
        }

        if (!empty($errors)) {
            throw new \Exception(implode(" ",$errors));
        }
    }
}