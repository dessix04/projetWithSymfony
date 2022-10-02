<?php
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
 
 
class TestSecurityController extends AbstractController
{
 
  /**
   * @Route("/secure_admin", name="test_secure_admin")
   */
  public function indexAdmin(Security $security): Response {
    $user = $security->getUser()->getUsername();
    $roles = implode('-', $security->getUser()->getRoles());
    return $this->renderForm('text_security/index.html.twig', ['username' => $user, 
                                                          'message' => "Vous êtes authentifié en $roles (ROLE_ADMIN requis)"]);
 }
 
  /**
   * @Route("/secure_user", name="test_secure_user")
   */
  public function indexUser(Security $security): Response {
    $user = $security->getUser()->getUsername();
    $roles = implode('-', $security->getUser()->getRoles());
    return $this->renderForm('text_security/index.html.twig', ['username' => $user,
                                                          'message' => "Vous êtes authentifié en $roles (ROLE_USER requis)"]);
  }
 
  /**
   * @Route("/secure_auth", name="test_secure_auth")
   */
  public function indexAuth(Security $security): Response {
    $user = $security->getUser()->getUsername();
    $roles = implode('-', $security->getUser()->getRoles());
    return $this->renderForm('text_security/index.html.twig', ['username' => $user,
                                                          'message' => "Vous êtes authentifié en $roles (Aucun rôle spécifique requis)"]);
  }
 
  /**
   * @Route("/suis_rien", name="test_rien_auth")
   */
  public function indexNoAuth(Security $security): Response {
    if ($security->getUser()) {
      $user = $security->getUser()->getUsername();
      $roles = implode('-', $security->getUser()->getRoles());
    } else {
      $user = '--';
      $roles = '--';
    }
    return $this->renderForm('text_security/index.html.twig', ['username' => $user,
                                                          'message' => "Vous êtes authentifié en $roles (Aucune authentification n'est demandée)"]);
  }
 
}
