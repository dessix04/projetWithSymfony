<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
 
use Symfony\Component\Form\Extension\Core\Type\TextType;    // utile pour formulaires
use Symfony\Component\Form\Extension\Core\Type\DateType;    // utile pour formulaires
use Symfony\Component\Form\Extension\Core\Type\SubmitType;  // utile pour formulaires
use App\Entity\PersonneCheck;
 
class FormBackController extends AbstractController
{
 
  /**
   * @Route("/test_back", name="test_form_back")
   */
  public function index(Request $request): Response {
    $alert = '';
    $excpt = '';
    $form = null;
    $prs = new PersonneCheck();
 
    try {
      $form = $this->createFormBuilder($prs, ['csrf_protection' => true,
                                              'csrf_field_name' => 'mon_csrf',
                                              'attr' => ['novalidate' => 'novalidate',
                                                         'class' => 'perso']])
                   ->setMethod('POST')
                   ->add('nom',       TextType::class)
                   ->add('prenom',    TextType::class, ['attr' => ['pattern' => '[[:alnum:]]+']])
                   ->add('dateNaiss', DateType::class, ['label' => 'Date de naissance',
							'widget' => 'single_text',
                                                        'required' => false])
                   ->add('numSecu',   TextType::class, ['label' => 'Numéro de Sécu Sociale'])
                   ->add('envoi',     SubmitType::class)
                   ->getForm();
 
      $form->handleRequest($request);
 
      if ($form->isSubmitted() && $form->isValid()) {
        //      return $this->redirect($this->generateUrl('_welcome'));
        return $this->render('form_back/index.html.twig', ['exception' => $excpt,
                                                          'errors' => $alert,
                                                          'nom' => $prs->getNom(),
                                                          'prenom' => $prs->getPrenom(),
                                                          'date' => $prs->getDateNaiss(),
                                                          'num' => $prs->getNumSecu()]);
      } elseif ($form->isSubmitted()) {
        $alert= "not valid";
      }
 
    } catch (\Exception $e) {
      $excpt = $e->getMessage();
    }
    return $this->renderForm('form_simple/index.html.twig', ['exception' => $excpt,
                                                            'errors' => $alert,
                                                            'form' => $form]);
  }
}
