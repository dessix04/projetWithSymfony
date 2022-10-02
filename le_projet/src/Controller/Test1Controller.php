<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Test1Controller extends AbstractController
{
        public function Bonjour($nom, $prenom) {
          return $this->render('test1/index.html.twig',
                                     ['nom'    => $nom,
                                      'prenom' => $prenom]);
        }
}
