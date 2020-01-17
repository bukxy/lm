<?php

namespace App\Controller;

use App\Entity\ConstructionCat;
use App\Repository\ConstructionRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ConstructionCatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
    * @Route("/construction")
    */
class ConstructionController extends AbstractController
{
    /**
     * @Route("/", name="construction")
     */
    public function index(ConstructionRepository $c, ConstructionCatRepository $cc, Request $request, PaginatorInterface $paginator)
    {
        $allCons = $c->findAll();
                
        // Paginate the results of the query
        $cs = $paginator->paginate(
            // Doctrine Query, not results
            $allCons,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            1
        );

        return $this->render('front/construction.html.twig', [
            'construction' => $cs,
            'constructionCat' => $cc->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="construction_filter")
     */
    public function filter(ConstructionRepository $c, ConstructionCatRepository $ccRepo, ConstructionCat $cc, Request $request, PaginatorInterface $paginator)
    {

        $allCons = $c->findBy(['constructionCat' => $cc->getId()]);

        // Paginate the results of the query
        $cs = $paginator->paginate(
            // Doctrine Query, not results
            $allCons,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            1
        );

        return $this->render('front/construction.html.twig', [
            'construction' => $cs,
            'constructionCat' => $ccRepo->findAll(),
        ]);
    }
}
