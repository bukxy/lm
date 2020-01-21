<?php

namespace App\Controller;

use App\Entity\Events;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
    * @Route("/evenement")
    */
class EventsController extends AbstractController
{
    /**
     * @Route("/{id}", name="evenement")
     */
    public function index(Events $e)
    {              
        return $this->render('front/event.html.twig', [
            'event' => $e
        ]);
    }
}
