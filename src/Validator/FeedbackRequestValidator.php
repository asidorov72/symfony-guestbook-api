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

    private const MESSAGE_FIELD_MAX_LENGTH = 2000;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($array)
    {
        $errors = [];

        // use the validator to validate the value
        if (!empty($array['email'])) {
            $emailConstraint = new Assert\Email();
            // all constraint "options" can be set this way
            $emailConstraint->message = 'Invalid email address';

            $emailErrors = $this->validator->validate(
                $array['email'],
                $emailConstraint
            );

            if (0 < count($emailErrors)) {
                $errors[] = $emailErrors;
            }
        }

        if (empty($array['message'])) {
            $errors[] = 'The field "message" is required.';
        } elseif (strlen($array['message']) > self::MESSAGE_FIELD_MAX_LENGTH) {
            $errors[] = 'The field "message" text is too long.';
        }

        if (!empty($errors)) {
            throw new \Exception(implode(" ",$errors));
        }
    }
}
