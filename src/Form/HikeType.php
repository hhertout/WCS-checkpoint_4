<?php

namespace App\Form;

use App\Entity\Hike;
use App\Entity\Location;
use App\Entity\PointOfInterest;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class HikeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre",
            ])
            ->add('imageFile', VichFileType::class, [
                'label' => 'Bannière',
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                "label" => "Type",
                "choices" => [
                    "Ballade Familiale" => "Familiale",
                    "Randonnée" => "Randonnée",
                    "Aplinisme" => "Alpinisme"
                ],
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('short', TextType::class, [
                "label" => "Phrase de présentation",
            ])
            ->add('season', ChoiceType::class, [
                "label" => "Saison",
                'choices' => [
                    'Été' => 'summer',
                    'Hiver' => 'winter',
                ],
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('route', CKEditorType::class, [
                "label" => "Parcours",
            ])
            ->add('description', CKEditorType::class, [
                "label" => "Description",
            ])
            ->add('elevation', IntegerType::class, [
                "label" => "Dénivelé positif (m)",
            ])
            ->add('distance', IntegerType::class, [
                "label" => "Distance (km)",
            ])
            ->add('difficulty', ChoiceType::class, [
                "label" => "Difficulé",
                'choices' => [
                    "1 - Très Facile" => 1,
                    "2 - Facile" => 2,
                    "3 - Moyen" => 3,
                    "4 - Peu Difficile" => 4,
                    "5 - Très Difficile" => 5,
                ]
            ])
            ->add('location', EntityType::class, [
                "label" => "Localisation",
                "class" => Location::class,
                "choice_label" => "city",
                'multiple' => false,
                'expanded' => false,
                'autocomplete' => true,
            ])
            ->add('pointOfInterests', EntityType::class, [
                "class" => PointOfInterest::class,
                'choice_label' => 'title',
                'label' => "Points d'intérêt",
                'multiple' => true,
                'autocomplete' => true,
             ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hike::class,
        ]);
    }
}
