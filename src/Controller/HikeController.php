<?php

namespace App\Controller;

use DateTime;
use App\Entity\Hike;
use App\Entity\Comment;
use App\Entity\SearchBar;
use App\Form\CommentType;
use App\Form\SearchbarType;
use App\Services\AverageRate;
use App\Repository\HikeRepository;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HikeController extends AbstractController
{
    public const SEASON = ["winter", "summer"];
    #[Route('/decouvrir', name: 'app_hike_summer')]
    public function summer(HikeRepository $hikeRepository, AverageRate $averageRate, Request $request): Response
    {
        $season = self::SEASON[1];
        $hikes = $hikeRepository->findBy(["season" => $season]);

        $search = new SearchBar();
        $form = $this->createForm(SearchbarType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search->setSeason($season);
            $hikes = $hikeRepository->findBySearch($search);
        }

        foreach($hikes as $hike) {
            $hike->setAverageRate($averageRate->get($hike));
        }
        return $this->render('hike/summer/summer.html.twig', [
            "hikes" => $hikes,
            "form" => $form,
        ]);
    }
    #[Route('/decouvrir-hiver', name: 'app_hike_winter')]
    public function winter(HikeRepository $hikeRepository, AverageRate $averageRate, Request $request): Response
    {
        $season = self::SEASON[0];
        $hikes = $hikeRepository->findBy(["season" => $season]);

        $search = new SearchBar();
        $form = $this->createForm(SearchbarType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $search->setSeason($season);
            $hikes = $hikeRepository->findBySearch($search);
        }

        foreach($hikes as $hike) {
            $hike->setAverageRate($averageRate->get($hike));
        }
        return $this->render('hike/winter/winter.html.twig', [
            "hikes" => $hikes,
            "form" => $form,
        ]);
    }
    #[Route('/decouvrir-hiver/{slug}', name: 'app_hike_winter_show', methods: ['GET', 'POST'])]
    public function showWinter(Hike $hike, CommentRepository $commentRepository, Request $request, AverageRate $averageRate): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $average = $averageRate->get($hike);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTime();
            $comment->setCreationDate($date);
            $comment->setUser($this->getUser());
            $comment->setHikes($hike);

            $commentRepository->save($comment, true);

            $this->addFlash('success', 'Votre commentaire à été posté avec succès');

            return $this->redirectToRoute('app_hike_winter_show', ['slug' => $hike->getSlug()]);
        }

        $comments = $commentRepository->findBy(["hikes" => $hike]);
        return $this->render('hike/winter/show.html.twig', [
            "hike" => $hike,
            "comments" => $comments,
            "averageRate" => $average,
            "form" => $form,
        ]);
    }
    #[Route('/decouvrir/{slug}', name: 'app_hike_summer_show', methods: ['GET', 'POST'])]
    public function showSummer(Hike $hike, CommentRepository $commentRepository, Request $request, AverageRate $averageRate): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $average = $averageRate->get($hike);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTime();
            $comment->setCreationDate($date);
            $comment->setUser($this->getUser());
            $comment->setHikes($hike);

            $commentRepository->save($comment, true);

            $this->addFlash('success', 'Votre commentaire à été posté avec succès');

            return $this->redirectToRoute('app_hike_summer_show', ['slug' => $hike->getSlug()], Response::HTTP_SEE_OTHER);
        }

        $comments = $commentRepository->findBy(["hikes" => $hike]);
        return $this->render('hike/summer/show.html.twig', [
            "hike" => $hike,
            "comments" => $comments,
            "averageRate" => $average,
            "form" => $form,
        ]);
    }
    #[Route('/decouvrir/{slug}/{comment}', name: 'app_comment_delete', methods: ['POST'])]
    public function deleteComment(Hike $hike, Comment $comment, Request $request, CommentRepository $commentRepository): Response
    {
        $season = $hike->getSeason();
        if ($season === "winter") {
            $route = "app_hike_winter_show";
        } else {
            $route = "app_hike_summer_show";
        }
        
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $commentRepository->remove($comment, true);

            $this->addFlash('danger', 'Le commentaire à bien été supprimé');
        }
         return $this->redirectToRoute($route, ['slug' => $hike->getSlug()], Response::HTTP_SEE_OTHER);
    }
}
