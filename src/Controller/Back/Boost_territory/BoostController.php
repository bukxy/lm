<?php

namespace App\Controller\Back\Boost_territory;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;

use App\Entity\BoostTerritory;
use App\Form\BoostTerritoryType;
use App\Repository\BoostTerritoryRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/boost")
*/
class BoostBackController extends AbstractController
{
    /**
     * @Route("/", name="admin_boost_list")
     */
    public function listBoost(BoostTerritoryRepository $b)
    {
        return $this->render('back/boost/boostList.html.twig', [
            'boosts' => $b->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_boost_new")
     * @Route("/edit/{id}", name="admin_boost_edit")
     */
    public function AddEdit(BoostTerritory $b = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$b) {
            $b = new BoostTerritory();
        }

        $formBT = $this->createForm(BoostTerritoryType::class, $b);
        $formBT->handleRequest($req);

        if ($formBT->isSubmitted() && $formBT->isValid()){

            $user = $security->getUser();

            $b->setImage(null);
            $b->setUser($user);
            $manager->persist($b);
            $manager->flush();
            return $this->redirectToRoute('admin_boost_list');
        }

        return $this->render('back/boost/boostAddEdit.html.twig', [
            'formBoost' => $formBT->createView(),
            'editMode'  => $b->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_boost_delete")
     */
    public function delete(BoostTerritory $b, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $manager->remove($b);
            $manager->flush();

            return $this->redirectToRoute('admin_boost_list');
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/image/add/{id}", name="admin_boost_new_image")
     */
    public function AddImage(BoostTerritory $b, Image $i = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$i) {
            $i = new Image();
        }

        $formImg = $this->createForm(ImageType::class, $i);
        $formImg->handleRequest($req);

        if ($formImg->isSubmitted() && $formImg->isValid()){

            /** @var UploadedFile $brochureFile */
            $brochureFile = $formImg['name']->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('boost_folder'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents

            $user = $security->getUser();

            $b->setImage($i);
            $i->setUser($user);

            $i->setName($newFilename);

            if ($formImg['alt']->getData() == null){
                $i->setAlt('Aucune information sur l\'image est disponible');
            }

            $manager->persist($b);
            $manager->persist($i);
            $manager->flush();
            return $this->redirectToRoute('admin_boost_list');
        }

        return $this->render('back/boost/boostAddEditImage.html.twig', [
            'formImg' => $formImg->createView(),
            'editMode'  => $b->getId() !== null
        ]);
    }

    /**
     * @Route("/image/delete/{id}", name="admin_boost_delete_image")
     */
    public function deleteImage(BoostTerritory $b, ImageRepository $i, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $image = $i->findOneBy(['id' => $b->getImage()]);

            $path = '/uploads/boost_territory/' . $image->getName();

            if ($image && file_exists($path)){
                unlink($path);
                $b->setImage(null);
                $manager->remove($image);
                $manager->flush();
                return $this->redirectToRoute('admin_boost_list');
            }
        }
    }
}
