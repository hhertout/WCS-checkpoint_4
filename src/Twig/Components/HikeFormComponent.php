<?php

namespace App\Twig\Components;

use App\Entity\Hike;
use App\Form\HikeType;
use App\Form\PointOfInterestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent('hike_form')]
final class HikeFormComponent extends AbstractController
{

    use DefaultActionTrait;
    use LiveCollectionTrait;

    #[LiveProp(fieldName: 'poi')]
    public ?Hike $hike = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(HikeType::class, $this->hike);
    }
    #[LiveAction]
    public function save(EntityManagerInterface $entityManager)
    {
        // shortcut to submit the form with form values
        // if any validation fails, an exception is thrown automatically
        // and the component will be re-rendered with the form errors
        $this->submitForm();

        /** @var Post $post */
        $hike = $this->getFormInstance()->getData();
        $entityManager->persist($hike);
        $entityManager->flush();

        $this->addFlash('success', 'Post saved!');

        return $this->redirectToRoute('/admin/hike');
    }
    #[LiveAction]
    public function addPoi()
    {
        // "formValues" represents the current data in the form
        // this modifies the form to add an extra comment
        // the result: another embedded comment form!
        // change "comments" to the name of the field that uses CollectionType
        $this->formValues['title'][] = [];
    }

    #[LiveAction]
    public function removePoi(#[LiveArg] int $index)
    {
        unset($this->formValues['title'][$index]);
    }

}