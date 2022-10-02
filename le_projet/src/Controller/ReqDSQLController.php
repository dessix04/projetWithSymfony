<?php
 
namespace App\Controller;
 
use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
 
class ReqDSQLController extends AbstractController {
 
  /**
   * @Route(
   *        "/read_dsql_table/{column}-{min}-{max}",
   *        name="read_dsql_table",
   *        defaults={"order": "desc"},
   *        requirements={
   *                      "column": "[0-9a-z_]+",
   *                      "min": "\d+",
   *                      "max": "\d+",
   *                      "order": "asc|desc",
   *        }
   * )
   */
  public function read(ManagerRegistry $doctrine, string $column, int $min, int $max, string $order): response {
 
    $alert = '';
    $res_array = [];
    try {
 
      $rep = $doctrine->getRepository(Ville::class);
 
      // ces lignes sont commentées car le test est réalisé par une classe externe.
      //$qb = $rep->createQueryBuilder('p')->where("p.$column > :min AND p.$column < :max");
 
 
      //if (strtolower($order) == 'asc') {
      //  $qb->orderBy("p.$column", 'ASC');
      //} else {
      //  $qb->orderBy("p.$column", 'DESC');
      //}
 
      //$query = $qb->getQuery();
      //$query->setParameter('max', $max)->setParameter('min', $min);
 
 
      //$results = $query->getResult();
 
      // la ligne ci dessous utilise la fonction findMinMax déclarée dans la classe Entity/VillesRepository de ce Bundle.
      $results = $rep->findMinMax($column, $min, $max, $order);
 
      $fields = ['nom', 'pop', 'dept'];
      foreach ($results as $result) {
        $res = [];
        foreach ($fields as $col) {
          $getf = 'get'.ucfirst($col);
          $res[$col] = $result->$getf();
        }
        $res_array[] = $res;
      }
    } catch (\Exception $e) {
      $alert = $e->getMessage();
    }
    return $this->render('marc_read_tables/index.html.twig', [
       // 'testvar' => $results,
        'results' => $res_array,
        'errors' => $alert,
        'table' => 'Villes']);
  }
 
}
