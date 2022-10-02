<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestIncludeController extends AbstractController
{
    /**
     * @Route("/testinc", name="app_test_include")
     */
    public function index(): Response
    {
        return $this->render('test_include/do_include.html.twig', [
            'noms' => [
                ['djibril', 'Bah', 31],
                ['Kao', 'kome', 42],
                ['Mehdi', 'Zeee', 33],
            ]
        ]);
    }
}
