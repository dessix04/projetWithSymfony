<?php
namespace App\Validator\Constraint;
 
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
 
class NumSecuValidator extends ConstraintValidator {
 
  public function validate($value, Constraint $constraint) {
    if (!preg_match('/^[12][0-9]{12}$/', $value)) {
      $this->context->addViolation($constraint->message,
				   array('%string%' => $value));
    }
  }
}