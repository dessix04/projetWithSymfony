<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class DeptRegionController extends AbstractController
{

  /**
   * @Route(
   *        "/fill",
   *        name="fill_deptreg",
   * )
   */
  public function fill(ManagerRegistry $doctrine): Response {
    $alert = '';
    $region_list = [];
    $num_depts = 0;
    try {
      $doc_db = $doctrine->getManager();
      
      $rfile ="/var/www/html/tp/le_projet/Data/geo_france.csv";
      if (($handle = fopen($rfile, "r")) !== FALSE) {
        $reg_get = $doctrine->getRepository(Region::class);
        if ($reg_get->findAll()) throw new \Exception("Les tables sont déjà remplies !");

        while (($dptreg = fgetcsv($handle, 1000, "\t")) !== FALSE) {
          if (!$reg = $reg_get->findOneByNom($dptreg[2])) {
            // Si la région n'existe pas il faut la créer
            $reg = new Region();
            $reg->setNom($dptreg[2]);
            $doc_db->persist($reg);
            $region_list[] = $dptreg[2];
          }
          $num_depts++;
          // création du département
          $dep = new Departement();
          $dep->setNom($dptreg[0]);
          $dep->setCode($dptreg[1]);
          // utilisation de la clef étrangère
          $dep->setRegion($reg);
          $doc_db->persist($dep);
          $doc_db->flush();
        }
      } else {
        $alert = "fichier <samp>".$rfile."</samp>impossible à ouvrir";
      }
    } catch (\PDOException $e) {
      $alert = $e->getTraceAsString();
    } catch (\Exception $e) {
      $alert = $e->getMessage();
    }
    return $this->render('dept_region/index.html.twig', ['results' => $region_list,
                                                       'num_depts' => $num_depts,
                                                       'errors' => $alert]);
  }

  /**
   * @Route(
   *        "/region/{id}",
   *        name="read_region",
   *        requirements={"id": "\d+"},
   * )
   */
  public function AfficheRegion(ManagerRegistry $doctrine, int $id): Response {
    $alert = '';
    $dept_list = [];
    try {
      $doc_db = $doctrine->getRepository(Departement::class);
      $reg_get = $doctrine->getRepository(Region::class);

      if (!$reg = $reg_get->find($id)) {
        $alert = "La region dont l'identité est <em>".$id."</em> n'est pas présente.";
        $region = '';
      } else {
        $region = $reg->getNom();
        //      $dptall = $reg->getDepartements();echo get_class($dptall[0])."<br/>------\n";print_r($dptall[0]);exit;
        foreach ($reg->getDepartements() as $dpt) {
          $dept_list[] = $dpt->getNom();
        }
      }
    } catch (\Exception $e) {
      $alert = $e->getMessage();
    }
    return $this->render('dept_region/ville.html.twig', ['departements' => $dept_list,
                                                                'region' => $region,
                                                                'errors' => $alert]);
  }
}