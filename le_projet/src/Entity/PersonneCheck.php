<?php
namespace App\Entity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Regex;
use App\Validator\Constraint\NumSecu;
 
class PersonneCheck {
    protected $nom;       // propriétés à lier
    protected $prenom;    // automatiquement
    protected $dateNaiss; // au formulaire
    protected $numSecu;   // avec validations
 
    // mise en place des contraintes de vérification
    public static function
      loadValidatorMetadata(ClassMetadata $metadata) {
      $metadata->addPropertyConstraint('nom', new NotBlank())
               ->addPropertyConstraint('nom', new Regex('/^[[:alpha:][:space:]-]+$/u'))
               ->addPropertyConstraint('prenom', new NotBlank())
               ->addPropertyConstraint('prenom', new Regex('/^[[:alpha:]-]+$/u'))
               ->addPropertyConstraint('dateNaiss', new NotBlank())
               ->addPropertyConstraint('numSecu', new NotBlank())
               ->addPropertyConstraint('numSecu', new NumSecu());
    }
 
    public function getNom() {
        return $this->nom;
    }
 
    public function setNom($nom) {
        $this->nom = $nom;
    }
 
    public function getPrenom() {
        return $this->prenom;
    }
 
    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }
 
    public function getDateNaiss() {
        return $this->dateNaiss;
    }
 
    public function setDateNaiss($dateNaiss) {
        $this->dateNaiss = $dateNaiss;
    }
 
    public function getNumSecu() {
        return $this->numSecu;
    }
 
    public function setNumSecu($numSecu) {
        $this->numSecu = $numSecu;
    }
}
