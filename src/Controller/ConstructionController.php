<?php

namespace App\Controller;

use App\Entity\Construction;
use App\Repository\ConstructionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/construction", name="construction_")
*/
class ConstructionController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function index(ConstructionRepository $c)
    {
        return $this->render('front/construction.html.twig', [
            'constructions' => $c->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="one")
     */
    public function filter(Construction $c = null, Request $request)
    {
        if ($c) {
            $url = $request->server->get('HTTP_HOST');

            return $this->json([
                    'message'       =>  true,
                    'url'           =>  'https://'. $url . '/uploads',
                    'result'        =>  $c
                ], 200, [],
                    ['groups' => ['construction:read', 'image:read'] ]
            );
        } else {
            return $this->json([
                'message' => false
            ], 200);
        }
    }
}
