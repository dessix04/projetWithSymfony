<?php
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Style {
  /**
   * @Assert\NotBlank()
   */
  protected $color = '#FF00FF'; // propriété à lier
  
  /**
   * @Assert\NotBlank()
   */
  protected $font = 'arial';  // propriété à lier
  
  /**
   * @Assert\NotBlank()
   * @Assert\Regex(pattern= "/^[_ [:alpha:]]{1,10}$/u")
   */
  protected $string = '';  // propriété à lier
  
  public function getColor() {
    return $this->color;
  }

  public function setColor($color) {
    $this->color = $color;
  }
  
  public function getFont() {
    return $this->font;
  }

  public function setFont($font) {
    $this->font = $font;
  }

  public function getString() {
    return $this->string;
  }
  
  public function setString($string) {
    $this->string = $string;
  }
}