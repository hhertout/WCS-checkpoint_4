<?php

namespace App\Controller;

use App\Entity\PointOfInterest;
use App\Form\PointOfInterestType;
use App\Repository\PointOfInterestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/poi')]
class AdminPoiController extends AbstractController
{
    #[Route('/', name: 'app_admin_poi_index', methods: ['GET'])]
    public function index(PointOfInterestRepository $pointOfInterestRepository): Response
    {
        return $this->render('admin_poi/index.html.twig', [
            'point_of_interests' => $pointOfInterestRepository->findBy([], ["title" => "ASC"]),
        ]);
    }

    #[Route('/new', name: 'app_admin_poi_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PointOfInterestRepository $pointOfInterestRepository): Response
    {
        $pointOfInterest = new PointOfInterest();
        $form = $this->createForm(PointOfInterestType::class, $pointOfInterest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pointOfInterestRepository->save($pointOfInterest, true);

            $this->addFlash('success', 'Le point d\'intérêt à bien été enregistré');

            return $this->redirectToRoute('app_admin_poi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_poi/new.html.twig', [
            'point_of_interest' => $pointOfInterest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_poi_show', methods: ['GET'])]
    public function show(PointOfInterest $pointOfInterest): Response
    {
        return $this->render('admin_poi/show.html.twig', [
            'point_of_interest' => $pointOfInterest,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_poi_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PointOfInterest $pointOfInterest, PointOfInterestRepository $pointOfInterestRepository): Response
    {
        $form = $this->createForm(PointOfInterestType::class, $pointOfInterest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pointOfInterestRepository->save($pointOfInterest, true);

            $this->addFlash('success', 'Le point d\'intérêt à bien été enregistré');

            return $this->redirectToRoute('app_admin_poi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_poi/edit.html.twig', [
            'point_of_interest' => $pointOfInterest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_poi_delete', methods: ['POST'])]
    public function delete(Request $request, PointOfInterest $pointOfInterest, PointOfInterestRepository $pointOfInterestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pointOfInterest->getId(), $request->request->get('_token'))) {
            $pointOfInterestRepository->remove($pointOfInterest, true);

            $this->addFlash('danger', 'Le point d\'intérêt à bien été supprimé');
        }

        return $this->redirectToRoute('app_admin_poi_index', [], Response::HTTP_SEE_OTHER);
    }
}
