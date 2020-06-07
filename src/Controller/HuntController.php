<?php

namespace App\Controller;

use App\Entity\Hunt;
use App\Entity\HuntCat;
use App\Repository\ImageRepository;
use App\Repository\HuntRepository;
use App\Repository\HuntCatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/hunt", name="hunt_")
*/
class HuntController extends AbstractController
{
    /**
    * @Route("/", name="list")
    */
    public function index(HuntRepository $h, HuntCatRepository $hc, Request $request)
    {                
        return $this->render('front/hunt.html.twig', [
            'huntIcon' => $h->findAll(),
            'huntCat' => $hc->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="one", methods={"POST"})
     */
    public function oneHunt(Hunt $h = null, Request $request)
    {
        if ($h) {
            $url = $request->server->get('HTTP_HOST');
            if ($_SERVER['HTTPS']){
                $http = 'https';
            } else {
                $http = 'http';
            }

            return $this->json([
                    'message'       =>  true,
                    'url'           =>  $http .'://'. $url . '/uploads/images/',
                    'result'        =>  $h
                ], 200, [],
                    ['groups' => ['huntByCat:read', 'image:read']]
            );
        } else {
            return $this->json([
                'message' => false
            ], 200);
        }
    }

    /**
     * @Route("/category/{id}", name="listByCategory", methods={"POST"})
     */
    public function listByCategory(HuntCat $hcat = null, HuntRepository $hRepo, Request $request)
    {
        if ($hcat) {
            $url = $request->server->get('HTTP_HOST');
            if ($_SERVER['HTTPS']){
                $http = 'https';
            } else {
                $http = 'http';
            }

            return $this->json([
                    'message'       =>  true,
                    'result'        =>  $hRepo->findBy(['huntCat' => $hcat->getId()])
                ], 200, [],
                    ['groups' => ['huntByCat:read', 'image:read']]
            );
        } else {
            return $this->json([
                'message' => false
            ], 200);
        }
    }
}
