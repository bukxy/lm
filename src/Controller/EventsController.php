<?php

namespace App\Controller;

use App\Entity\Events;
use App\Repository\EventsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
    * @Route("/evenement")
    */
class EventsController extends AbstractController
{
    /**
     * @Route("/{slug}", name="evenement")
     */
    public function index(Events $e, EventsRepository $repo)
    {
        return $this->render('front/event.html.twig', [
            'event' => $e
        ]);
    }
}
