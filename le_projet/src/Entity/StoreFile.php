<?php
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * StoreFile
 *
 * @ORM\Table(name="storefile")
 * @ORM\Entity
 */
class StoreFile {
 
  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;
 
  /**
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   * @Assert\Regex(pattern= "/^[_ [:alpha:]]{1,50}$/u")
   */
  protected $comment;
 
  /**
   * @ORM\Column(type="string")
   * @Assert\Regex(pattern= "/^[_.[:alnum:]]{1,20}$/u")
   */
  protected $path;
 
 
  public function getId(): ?int
  {
    return $this->id;
  }
 
  public function getComment() {
    return $this->comment;
    }
 
  public function setComment($comment) {
    $this->comment = $comment;
  }
 
  public function getPath() {
    return $this->path;
  }
 
  public function setPath($path) {
    $this->path = $path;
  }
 
}
