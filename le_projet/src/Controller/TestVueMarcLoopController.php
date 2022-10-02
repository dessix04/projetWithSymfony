<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestVueMarcLoopController extends AbstractController
{
    public function index(): Response
    {
        {
            $prenoms = ['feminin' => ["Emma", "Jade", "Léa", "Chloé", "Manon", "Inès", "Camille", "Sarah", "Zoé", "Lola"],
                        'masculin' => ["Lucas", "Nathan", "Enzo", "Louis", "Mathis", "Jules", "Gabriel", "Hugo", "Raphaël", "Léo"]];
            return $this->render('test_vue_marc_loop/index.html.twig', ['prenoms' => $prenoms]);
          }
    }
}
