<?php

namespace App\Controller;

use App\Entity\BoostTerritory;
use App\Entity\BoostTerritoryCat;
use App\Repository\ImageRepository;
use App\Repository\BoostTerritoryRepository;
use App\Repository\BoostTerritoryCatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/boost", name="boost_")
*/
class BoostTerritoryController extends AbstractController
{
    /**
    * @Route("/", name="list")
    */
    public function index(BoostTerritoryRepository $b, BoostTerritoryCatRepository $bc, Request $request)
    {                
        return $this->render('front/boost.html.twig', [
            'boostIcon' => $b->findAll(),
            'boostCat' => $bc->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="one", methods={"POST"})
     */
    public function oneFamiliar(BoostTerritory $b = null, Request $request)
    {
        if ($b) {
            $url = $request->server->get('HTTP_HOST');
            if ($_SERVER['HTTPS']){
                $http = 'https';
            } else {
                $http = 'http';
            }

            return $this->json([
                    'message'       =>  true,
                    'url'           =>  $http .'://'. $url . '/uploads',
                    'result'        =>  $b
                ], 200, [],
                    ['groups' => ['boost:read', 'image:read']]
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
    public function listByCategory(BoostTerritoryCat $bcat = null, BoostTerritoryRepository $bRepo, Request $request)
    {
        if ($bcat) {
            $url = $request->server->get('HTTP_HOST');
            if ($_SERVER['HTTPS']){
                $http = 'https';
            } else {
                $http = 'http';
            }

            return $this->json([
                    'message'       =>  true,
                    'url'           =>  $http .'://'. $url . '/uploads',
                    'result'        =>  $bRepo->findBy(['category' => $bcat->getId()])
                ], 200, [],
                    ['groups' => ['boost:read', 'image:read']]
            );
        } else {
            return $this->json([
                'message' => false
            ], 200);
        }
    }
}
