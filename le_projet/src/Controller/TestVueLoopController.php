<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestVueLoopController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('test_vue_loop/index.html.twig', [
            'les_identites' =>[
                'nom' => ['djibril', 'kao', 'dalila'],
                'prenom' => ['Bah', 'kome', 'mehdi']
            ]
        ]);
    }
}
