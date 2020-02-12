<?php

namespace App\Controller;

use App\Entity\Familiar;
use App\Entity\FamiliarCat;
use App\Repository\ImageRepository;
use App\Repository\FamiliarRepository;
use App\Repository\FamiliarCatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/familiar", name="familiar_")
*/
class FamiliarController extends AbstractController
{
    /**
    * @Route("/", name="list")
    */
    public function index(FamiliarRepository $f, FamiliarCatRepository $fc, Request $request)
    {                
        return $this->render('front/familiar.html.twig', [
            'famIcon' => $f->findAll(),
            'famCat' => $fc->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="one", methods={"POST"})
     */
    public function oneFamiliar(Familiar $f = null, FamiliarRepository $fRepo, ImageRepository $iRepo, Request $request)
    {
        if ($f) {
            $url = $request->server->get('HTTP_HOST');

            return $this->json([
                    'message'       =>  true,
                    'url'           =>  'https://'. $url . '/uploads/images/',
                    'defaultImage'  =>  'https://'. $url . '/uploads/familiar.png',
                    'result'        =>  $f
                ], 200, [],
                    ['groups' => 'familiarByCat:read']
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
    public function listByCategory(FamiliarCat $fcat = null, FamiliarRepository $fRepo, ImageRepository $iRepo, Request $request)
    {
        if ($fcat) {
            $url = $request->server->get('HTTP_HOST');

            return $this->json([
                    'message'       =>  true,
                    'url'           =>  'https://'. $url . '/uploads/images/',
                    'defaultImage'  =>  'https://'. $url . '/uploads/familiar.png',
                    'result'        =>  $fRepo->findBy(['familiarCat' => $fcat->getId()])
                ], 200, [],
                    ['groups' => 'familiarByCat:read']
            );
        } else {
            return $this->json([
                'message' => false
            ], 200);
        }
    }
}
