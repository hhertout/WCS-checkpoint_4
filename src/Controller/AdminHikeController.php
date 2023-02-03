<?php

namespace App\Controller;

use App\Entity\Hike;
use App\Form\HikeType;
use App\Repository\HikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/hike')]
class AdminHikeController extends AbstractController
{
    #[Route('/', name: 'app_admin_hike_index', methods: ['GET'])]
    public function index(HikeRepository $hikeRepository): Response
    {
        return $this->render('admin_hike/index.html.twig', [
            'hikes' => $hikeRepository->findBy([], ["season" => "ASC", "title" => "ASC"]),
        ]);
    }

    #[Route('/new', name: 'app_admin_hike_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HikeRepository $hikeRepository, SluggerInterface $slugger): Response
    {
        $hike = new Hike();
        $form = $this->createForm(HikeType::class, $hike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hike->setSlug($slugger->slug($hike->getTitle()));
            $hikeRepository->save($hike, true);

            $this->addFlash('success', 'La sortie à bien été enregistrée');

            return $this->redirectToRoute('app_admin_hike_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_hike/new.html.twig', [
            'hike' => $hike,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_admin_hike_show', methods: ['GET'])]
    public function show(Hike $hike): Response
    {
        return $this->render('admin_hike/show.html.twig', [
            'hike' => $hike,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_admin_hike_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hike $hike, HikeRepository $hikeRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(HikeType::class, $hike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hike->setSlug($slugger->slug($hike->getTitle()));
            $hikeRepository->save($hike, true);

            $this->addFlash('success', 'La sortie à bien été enregistrée');

            return $this->redirectToRoute('app_admin_hike_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_hike/edit.html.twig', [
            'hike' => $hike,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_admin_hike_delete', methods: ['POST'])]
    public function delete(Request $request, Hike $hike, HikeRepository $hikeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hike->getSlug(), $request->request->get('_token'))) {
            $hikeRepository->remove($hike, true);

            $this->addFlash('danger', 'La sortie à bien été supprimée');
        }

        return $this->redirectToRoute('app_admin_hike_index', [], Response::HTTP_SEE_OTHER);
    }
}
