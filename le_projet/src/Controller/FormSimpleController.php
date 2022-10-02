<?php
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
 
use Symfony\Component\Form\Extension\Core\Type\TextType;    // utile pour formulaires
use Symfony\Component\Form\Extension\Core\Type\DateType;    // utile pour formulaires
use Symfony\Component\Form\Extension\Core\Type\SubmitType;  // utile pour formulaires
use App\Entity\Personne;
 
 
class FormSimpleController extends AbstractController
{
 
  /**
   * @Route(
   *        "/form_simple/{nom}/{prenom}/{date}-{numss}",
   *        name="test_form_simple",
   *        defaults={
   *                 "nom": "moi",
   *                 "prenom": "toi",
   *                 "date": "12-06-1989",
   *                 "numss": "1234567890123",
   *        },
   *        requirements={
   *                      "nom": "[[:alpha:]]+",
   *                      "prenom": "[-[:alpha:]]{2,10}",
   *                      "date": "[0-9]{1,2}-[0-9]{1,2}-[0-9]{4}",
   *                      "numss": "[1-2][0-9]{1,12}",
   *        }
   * )
   */
  public function index(string $nom, string $prenom, string $date, string $numss): Response {
    $excep = '';
    try {
      $datenaiss = \DateTime::createFromFormat('d-m-Y', $date);
      $prs = new Personne();
      $prs->setNom($nom);
      $prs->setPrenom($prenom);
      $prs->setDateNaiss($datenaiss);
      $prs->setNumSecu($numss);
      $form = $this->createFormBuilder($prs)
        ->setMethod('GET')
        ->add('nom',       TextType::class)   // mettre TextType::class en version 3 et + au lieu de 'text'
        ->add('prenom',    TextType::class)   // mettre 'text' en version 2 au lieu de TextType::class
        ->add('dateNaiss', DateType::class)   // mettre 'date' en version 2 au lieu de DateType::class
        ->add('numSecu',   TextType::class)
        ->add('envoi',     SubmitType::class) // mettre 'submit' en version 2 au lieu de SubmitType::class
        ->getForm();
 
      $vueform = $form->createView();
    } catch (\Exception $e) {
      $vueform = '';
      $excep = $e->getMessage();
    }
    return $this->render('form_simple/index.html.twig', ['exception' => $excep,
                                                        'form'      => $vueform]);
  }
}

