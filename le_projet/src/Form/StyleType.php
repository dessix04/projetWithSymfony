<?php
namespace App\Form;

use App\Entity\Style;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;

class StyleType extends AbstractType
{
  
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    //print_r($options);echo 'fini';exit;
    $builder->setMethod('GET');
    $builder->add('color', ColorType::class);
    $builder->add('string', TextType::class, ['attr' => ['placeholder' => 'La chaîne de caractères']]);
    $builder->add('font',  ChoiceType::class, ['choices' => ['courier' => 'Courier',
							     'arial'   => 'Arial',
							     'tahoma'  => 'Tahoma'],
					       'expanded' => TRUE]);
    $builder->add('send', SubmitType::class, ['label' => 'Envoyer']);
  }
  
  public function getName()
  {
    return 'style';
  }
  
  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Style::class,
    ]);
  }

}