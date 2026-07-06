<?php

namespace App\Form;

use App\Entity\Coach;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CoachFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('firstname', TextType::class, [
        'label' => 'coachForm.firstname',
      ])
      ->add('lastname', TextType::class, [
        'label' => 'coachForm.lastname',
      ])
      ->add('imageFile', VichImageType::class, [
        'required' => false,
        'allow_delete' => true,
        'delete_label' => 'Delete profile image',
        'download_uri' => true,
        'image_uri' => true,
        'asset_helper' => true,
        'imagine_pattern' => 'avatar_thumbnail',
        'label' => 'coachForm.image',
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Coach::class,
    ]);
  }
}
