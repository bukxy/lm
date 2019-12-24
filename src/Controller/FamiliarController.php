<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FamiliarController extends AbstractController
{
    /**
     * @Route("/familiar", name="familiar")
     */
    public function index()
    {
        return $this->render('familiar/index.html.twig', [
            'controller_name' => 'FamiliarController',
        ]);
    }
}
