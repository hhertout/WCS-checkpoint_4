<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'label' => 'Ville de dépendance'
            ])
            ->add('valley', TextType::class, [
                'label' => 'Vallée',
                'attr' => [
                    'maxlength' => 16
                ],
                'help' => '⚠️ 16 caractères max'
            ])
            ->add('latitude', NumberType::class, [
                'label' => "Latitude",
                "required" => false
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'longitude',
                "required" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
