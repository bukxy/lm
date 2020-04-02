<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(NewsRepository $n, Request $request, PaginatorInterface $paginator)
    {
        $news = $n->findAll();
        $result = $paginator->paginate(
            $news,
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1 // Nombre de résultats par page
        );

        return $this->render('front/news.html.twig', [
            'news' => $result
        ]);
    }

    /**
     * @Route("/calculator", name="calculator")
     */
    public function calculator()
    {
        return $this->render('front/calculator.html.twig', []);
    }
}
