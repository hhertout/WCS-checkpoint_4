<?php

namespace App\Twig;

use App\Entity\Hike;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent('hike_collection_type')]
class HikeCollectionTypeComponent extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public Hike $hike;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(HikeFormType::class, $this->hike);
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
