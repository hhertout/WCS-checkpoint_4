<?php

namespace App\Form;

use App\Entity\PointOfInterest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichFileType;


class PointOfInterestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre",
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description"
            ])
            ->add('posterFile', VichFileType::class, [
                "label" => "Photo",
                "required" => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PointOfInterest::class,
        ]);
    }
}
