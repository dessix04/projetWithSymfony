<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestLayoutController extends AbstractController
{
    
    public function index($nom, $prenom, $age): Response
    {
        return $this->render('test_layout/baseTest.html.twig',
                        ['nom'    => $nom,
                        'prenom' => $prenom,
                        'age' => $age]
                    );
    }

    public function bonjour(): Response
    {
        {
            $prenoms = ['feminin' => ["Emma", "Jade", "Léa", "Chloé", "Manon", "Inès", "Camille", "Sarah", "Zoé", "Lola"],
                        'masculin' => ["Lucas", "Nathan", "Enzo", "Louis", "Mathis", "Jules", "Gabriel", "Hugo", "Raphaël", "Léo"]];
            return $this->render('test_layout/tabLayout.html.twig', ['prenoms' => $prenoms]);
          }
    }
}
