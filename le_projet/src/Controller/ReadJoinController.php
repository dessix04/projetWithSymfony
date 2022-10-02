<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ReadJoinController extends AbstractController
{

  /**
   * @Route(
   *        "/read_departement/{dept}",
   *        name="read_dept_join",
   *        requirements={"dept": "[^/]*"},
   *        defaults={"dept": ""},
   * )
   */
  public function index(ManagerRegistry $doctrine, string $dept): Response {
    $alert = '';
    $results = [];
    
    try {
      $tbl = $doctrine->getRepository(Departement::class);

      if (empty($dept)) {
        $depts = $tbl->findAll();
      } else {
        $depts = $tbl->findByNom($dept);
      }
      
      foreach($depts as $dept) {
        // il y aura autant de requêtes que d'appels à chacune des méthodes ci dessous, soit 4 requêtes pour une seule itération
        $results[] = ['code'        => $dept->getCode(),
                      'département' => $dept->getNom(),
                      'région'      => $dept->getRegion()->getNom()];
      } 

    } catch (\PDOException $e) {
      $alert = $e->getMessage();
    }
    return $this->render('read_join/index.html.twig', ['results' => $results,
                                                        'errors' => $alert,
                                                        'table' => 'departement']);
  }

  /**
   * @Route(
   *        "/read_region/{region}/{explicit}",
   *        name="read_region_join",
   *        requirements={"region": "[^/0-9]+", "explicit":"0|1"},
   *        defaults={"explicit": 0},
   * )
   */
  public function region(ManagerRegistry $doctrine, string $region, bool $explicit=false): Response {
    $alert = '';
    $results = [];
    
    try {
      if ($explicit) {
        // utilisation de la méthode que NOUS avons déclaré
        $tbl = $doctrine->getRepository(Departement::class);
        $depts = $tbl->findExplicitDepts($region);
        foreach($depts as $dept) {
          $results[] = ['code'        => $dept['code'],
                        'département' => $dept['departement'],
                        'région'      => $dept['region']];
        }
      } else {
        // utilisation de la méthode par défaut de doctrine
        $tbl = $doctrine->getRepository(Region::class);
        $regobj = $tbl->findOneByNom($region);
        foreach($regobj->getDepartements()->toArray() as $dept) {
          $results[] = ['code'        => $dept->getCode(),
                        'département' => $dept->getNom(),
                        'région'      => $region];
        }
      }
    } catch (\Exception $e) {
      $alert = $e->getMessage();
    } catch (\Error $e) {
      $alert = $e->getMessage();
    }
    return $this->render('read_join/index.html.twig', ['results' => $results,
                                                        'errors' => $alert,
                                                        'table' => 'region et departement']);
  }
}