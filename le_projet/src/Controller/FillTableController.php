<?php

namespace App\Controller;
 
use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class FillTableController extends AbstractController
{
    /**
     * @Route("ville", name="create_ville")
     */
    public function createVille(ManagerRegistry $doctrine): Response
    {
      if ($doctrine->getRepository(Ville::class)->findAll()) $strg = "La table <var>ville</var> est déjà remplie !";
      else $strg = $this->fillTableVille($doctrine);
      return new Response($strg);
      
    }

    public function fillTableVille(ManagerRegistry $doctrine): string {
        try {
          $doc_db = $doctrine->getManager();
          $villes = [['Paris', 2211297, 75],
                     ['Marseille', 851420, 13],
                     ['Lyon', 474946, 69],
                     ['Toulouse', 439553, 31],
                     ['Nice', 344875, 6],
                     ['Nantes', 283288, 44],
                     ['Strasbourg', 272116, 67],
                     ['Montpellier', 252998, 34],
                     ['Bordeaux', 235891, 33],
                     ['Lille', 225784, 59]];
          foreach ($villes as $ville) {
            $v = new Ville();
             $v->setNom($ville[0]);
             $v->setPop($ville[1]);
            $v->setDept($ville[2]);
            $doc_db->persist($v);

           // unset($v);
          }
          $doc_db->flush();
          $strg = "Opération terminée";
        } catch (\Exception $e) {
          $strg = $e->getMessage();
        }
        return $strg;
      }
}
