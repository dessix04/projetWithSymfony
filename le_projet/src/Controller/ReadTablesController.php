<?php

namespace App\Controller;

use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ReadTablesController extends AbstractController
{
    /**
     * @Route("readtables/", name="app_read_tables")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
       $tab = $doctrine->getRepository(Ville::class)->findAll();
        return $this->render('read_tables/index.html.twig',
                                   ['tab'    => $tab]);
    }
}
