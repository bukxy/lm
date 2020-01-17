<?php

namespace App\Controller;

use App\Repository\FamiliarRepository;
use App\Repository\FamiliarCatRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FamiliarController extends AbstractController
{
    /**
     * @Route("/familiar", name="familiar")
     */
    public function index(FamiliarRepository $f, FamiliarCatRepository $fc, Request $request, PaginatorInterface $paginator)
    {
        $allFamiliars = $f->findAll();
        $allFamiliarsIcon = $f->findAll();
                
        // Paginate the results of the query
        $fams = $paginator->paginate(
            // Doctrine Query, not results
            $allFamiliars,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );

        return $this->render('front/familiar.html.twig', [
            'fam' => $fams,
            'famIcon' => $allFamiliarsIcon,
            'famCat' => $fc->findAll(),
        ]);
    }
}
