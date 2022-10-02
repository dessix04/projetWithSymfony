<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
 
class LoginMarcController extends AbstractController
{
  /**
   * @Route("login", name="app_login", defaults={"retry":false})
   */
  public function index(AuthenticationUtils $authenticationUtils, bool $retry): Response
  {
    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();
 
    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();
 
    return $this->render('login_marc/index.html.twig', [
      'last_username' => $lastUsername,
      'error'         => $error,
      'retry'         => $retry,
    ]);
  }
 
  // Cette fonction sera appelée en cas d'erreur d'autentification
  /**
   * @Route("/err_login", name="failed_login", defaults={"retry":true})
   */
  public function retry(AuthenticationUtils $authenticationUtils, bool $retry): Response
  {
    return $this->index($authenticationUtils, $retry);
  }
 
}
