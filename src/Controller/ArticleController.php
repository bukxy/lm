<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{slug}", name="article")
     */
    public function index(Article $a)
    {
        return $this->render('front/article.html.twig', [
            'article' => $a
        ]);
    }
}
