<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
