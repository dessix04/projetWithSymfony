<?php
namespace App\Validator\Constraint;
use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class NumSecu extends Constraint {
 
  public $message = "La chaîne \"%string%\" contient un caractère non autorisé. Elle ne peut contenir qu'une série de 13 chiffres.";
 
}