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

    public const MESSAGE_FIELD_MAX_LENGTH = 2000;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($array)
    {
        $errors = [];

        // use the validator to validate the value
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

        $msgConstraint = new Assert\Length([
            'min' => 10,
            'max' => self::MESSAGE_FIELD_MAX_LENGTH,
            'minMessage' => 'Your message must be at least {{ limit }} characters long',
            'maxMessage' => 'Your message cannot be longer than {{ limit }} characters',
            'allowEmptyString' => false,
        ]);

        $msgErrors = $this->validator->validate(
            $array['message'],
            $msgConstraint
        );

        if (0 < count($msgErrors)) {
            $errors[] = $msgErrors;
        }

        if (!empty($errors)) {
            throw new \Exception(implode(" ",$errors));
        }
    }
}
