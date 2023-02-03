<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\SearchBar;
use App\Repository\LocationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchbarType extends AbstractType
{
    public function __construct(private LocationRepository $locationRepository)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $locations = $this->locationRepository->getValley();
        $valleys = ["Toutes" => null];
        for ($i = 0; $i < count($locations); $i++) {
            $valleys = [...$valleys, $locations[$i]['valley'] => $locations[$i]['valley']] ;
        }

        $builder
            ->add('valley', ChoiceType::class, [
                "label" => "Localisation",
                'choices' => $valleys,
                'multiple' => false,
                'expanded' => false,

            ])
            ->add('type', ChoiceType::class, [
                "label" => "Type",
                "choices" => [
                    "Toutes" => null,
                    "Ballade Familiale" => "Familiale",
                    "Randonnée" => "Randonnée",
                    "Aplinisme" => "Alpinisme"
                ],
                'multiple' => false,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchBar::class,
        ]);
    }
}
