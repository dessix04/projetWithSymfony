<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{   
    public function index(string $nom, string $prenom, int $age): JsonResponse
    {
        return $this->json([
            'nom' => $nom,
            'prenom' => $prenom,
            'age' => $age
        ]);
    }

//positionne la variable url, si omise, à une valeur de route à analyser 

//n'accepte que des connexions de type get

//n'accepte des transferts de type http et refuse htpps

//n'accepte des connexions via le nom 127.0.0.1


//la route sera intégrée au ficiier 

public function showRoute(string $url): Response
{
  $strg = sprintf("<h3>route corespondant à <samp>%s</samp></h3>\n", htmlspecialchars($url));
  try {

    // celle-ci lance l'action showRoute du controlleur à partir d'url et cette action donnera les carctéristiques de la route visée
    $params = $this->get('router')->match($url);

    $strg .= sprintf("<pre>%s</pre>", print_r($params, true));
  } catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
    $strg = sprintf("<h3>aucune route ne correspond à <samp>%s</samp></h3>\n", htmlspecialchars($url));
    $strg .= sprintf("<p>le message d'erreur :<p><pre>%s</pre>\n", $e);
    $strg .= "<h4>Fin du message</h4>\n";
  }
  return new Response($strg);
}
}
