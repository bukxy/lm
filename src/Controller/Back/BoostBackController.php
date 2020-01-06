<?php

namespace App\Controller\Back;

use App\Entity\Image;
use App\Form\ImageType;
use App\Entity\BTCategory;
use App\Form\BTCategoryType;
use App\Entity\BoostTerritory;
use App\Form\BoostTerritoryType;

use App\Repository\ImageRepository;
use App\Repository\BTCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BoostTerritoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
* @Route("/admin")
*/
class BoostBackController extends AbstractController
{
    /**
     * @Route("/boost", name="admin_boost_list")
     */
    public function listBoost(BoostTerritoryRepository $b)
    {
        return $this->render('back/boost/boostList.html.twig', [
            'boosts' => $b->findAll()
        ]);
    }

    /**
     * @Route("/boost/new", name="admin_boost_new")
     * @Route("/boost/edit/{id}", name="admin_boost_edit")
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
     * @Route("/boost/delete/{id}", name="admin_boost_delete")
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
     * @Route("/boost/image/{id}", name="admin_boost_new_image")
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
     * @Route("/boost/image/delete/{id}", name="admin_boost_delete_image")
     */
    public function deleteImage(BoostTerritory $b, ImageRepository $i, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $image = $i->findOneBy(['id' => $b->getImage()]);

            $path = 'uploads/boost_territory/'.$image->getName();

            if ($image && file_exists($path)){
                unlink($path);
                $b->setImage(null);
                $manager->remove($image);
                $manager->flush();
                return $this->redirectToRoute('admin_boost_list');
            }
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/boost-category", name="admin_boost_category_list")
     */
    public function listCategory(BTCategoryRepository $b)
    {
        return $this->render('back/boost/catBoostList.html.twig', [
            'categories' => $b->findAll()
        ]);
    }

    /**
     * @Route("/boost-category/new", name="admin_boost_category_new")
     * @Route("/boost-category/edit/{id}", name="admin_boost_category_edit")
     */
    public function AddEditCategory(BTCategory $b = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$b) {
            $b = new BTCategory();
        }

        $form = $this->createForm(BTCategoryType::class, $b);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $security->getUser();
            $b->setUser($user);
            $manager->persist($b);
            $manager->flush();
            return $this->redirectToRoute('admin_boost_category_list');
        }

        return $this->render('back/boost/catBoostAddEdit.html.twig', [
            'formCatBoost' => $form->createView(),
            'editMode'  => $b->getId() !== null
        ]);
    }

    /**
     * @Route("/boost-category/delete/{id}", name="admin_boost_category_delete")
     */
    public function deleteCategory(BTCategory $b, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $manager->remove($b);
            $manager->flush();

            return $this->redirectToRoute('admin_boost_list');
        }
    }
}
