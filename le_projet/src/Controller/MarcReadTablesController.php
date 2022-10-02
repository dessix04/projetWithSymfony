<?php 
namespace App\Controller;
 
use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
 
class MarcReadTablesController extends AbstractController {
 
  /**
   * @Route(
   *        "/read_table/{table}-{column}={value}",
   *        name="read_table",
   *        defaults={
   *                 "table": "",
   *                 "column": "",
   *                 "value": "",
   *        },
   *        requirements={
   *                      "table": "[0-9a-z_]+",
   *                      "column": "[0-9a-z_]+",
   *        }
   * )
   */
  public function readColumn(ManagerRegistry $doctrine, string $table, string $column, $value): response {
    $alert = '';
    $res_array = [];
    try {
 
      $tbl = $doctrine->getRepository(Ville::class);
 
      if (empty($column)) {
        $results = $tbl->findAll();
      } else {
        $findproc = 'findBy'.ucfirst($column);
        $results = $tbl->$findproc($value);
      }
 
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
    return $this->render('marc_read_tables/index.html.twig', ['results' => $res_array,
                                                  'errors' => $alert,
                                                  'table' => $table]);
  }
 
}
