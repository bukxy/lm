<?php

namespace App\Controller\Back\Image_controller;

use App\Entity\ImageCat;
use App\Form\ImageCatType;
use App\Repository\ImageRepository;
use App\Repository\ImageCatRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/image-category")
*/
class ImageCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_image_category_list")
     */
    public function listCategory(ImageCatRepository $i)
    {
        return $this->render('back/image/catImageList.html.twig', [
            'categories' => $i->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_image_category_new")
     * @Route("/edit/{id}", name="admin_image_category_edit")
     */
    public function AddEditCategory(ImageCat $i = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$i) {
            $i = new ImageCat();
        }

        $form = $this->createForm(ImageCatType::class, $i);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $security->getUser();
            $i->setUser($user);
            $manager->persist($i);
            $manager->flush();
            return $this->redirectToRoute('admin_image_category_list');
        }

        return $this->render('back/image/catImageAddEdit.html.twig', [
            'formCatImage' => $form->createView(),
            'editMode'  => $i->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_image_category_delete")
     */
    public function deleteCategory(ImageCat $i, ImageRepository $imageRepo, ImageCatRepository $iCatRepo, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $imgs = $imageRepo->findBy(['imageCat' => $i->getId()]);
        
            if($imgs){
                $cat = $iCatRepo->find(['id' => 1]);
                foreach ($imgs as $img) {
                    $img->setImageCat($cat);
                    $manager->persist($img);
                }
            }

            $manager->remove($i);
            $manager->flush();

            return $this->redirectToRoute('admin_image_list');
        }
    }
}
