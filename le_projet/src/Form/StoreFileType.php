<?php
// src/Form/ProductType.php
namespace App\Form;
 
use App\Entity\StoreFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
 
class StoreFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
            ->add('comment', TextType::class, [
              'attr' => ['placeholder' => 'commentaire sur le fichier']])
            // ...
            ->add('path', FileType::class, [
              'label' => 'Chemin du fichier',
 
              // unmapped means that this field is not associated to any entity property
              'mapped' => false,
 
              // make it optional so you don't have to re-upload the PDF file
              // every time you edit the Product details
              'required' => false,
 
              // unmapped fields can't define their validation using annotations
              // in the associated entity, so you can use the PHP constraint classes
              'constraints' => [
                new File([
                  'maxSize' => '1024k',
                  'mimeTypes' => [
                    'image/jpeg',
                    'image/png',
                    'image/svg+xml',
                    'application/pdf',
                    'application/x-pdf',
                  ],
                  'mimeTypesMessage' => 'Chargez un fichier valide (image ou PDF)',
                ])
              ],
            ])
            ->add('send', SubmitType::class, ['label' => 'Envoyer']);
    }
 
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StoreFile::class,
        ]);
    }
}

