<?php 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
 
class TestVueTwigController extends AbstractController
{
  public function index(string $nom, string $prenom, int $age): Response
  {
    return $this->render('test_vue_twig/index.html.twig',
                         ['nom' => $nom,
                          'prenom' => $prenom,
                          'age' => $age]);
  }
 
}

