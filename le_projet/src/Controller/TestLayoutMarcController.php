<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestLayoutMarcController extends AbstractController
{
    public function index(): Response
  {
    $prenoms = ["Emma", "Jade", "Léa", "Chloé", "Manon",
                "Inès", "Camille", "Sarah", "Zoé", "Lola",
                "Lucas", "Nathan", "Enzo", "Louis", "Mathis",
                "Jules", "Gabriel", "Hugo", "Raphaël", "Léo"];
    shuffle($prenoms);
    return $this->render('test_layout_marc/baseTest.html.twig', ['prenoms' => $prenoms]);
  }
}
