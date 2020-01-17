<?php

namespace App\Controller\Back\Familiar;

use App\Entity\FamiliarCat;
use App\Form\FamiliarCatType;
use App\Repository\FamiliarCatRepository;

use App\Repository\FamiliarRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/familiar-category")
*/
class FamiliarCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_familiar_category_list")
     */
    public function list(FamiliarCatRepository $f)
    {
        return $this->render('back/familiar/catList.html.twig', [
            'categories' => $f->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_familiar_category_new")
     * @Route("/edit/{id}", name="admin_familiar_category_edit")
     */
    public function AddEditCategory(FamiliarCat $f = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$f) {
            $f = new FamiliarCat();
        }

        $form = $this->createForm(FamiliarCatType::class, $f);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $security->getUser();
            $f->setUser($user);
            $manager->persist($f);
            $manager->flush();
            return $this->redirectToRoute('admin_familiar_category_list');
        }

        return $this->render('back/familiar/catAddEdit.html.twig', [
            'formCat' => $form->createView(),
            'editMode'  => $f->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_familiar_category_delete")
     */
    public function deleteCategory(FamiliarCat $f, FamiliarCatRepository $fCatRepo, FamiliarRepository $fRepo, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $fs = $fRepo->findBy(['familiarCat' => $f->getId()]);
        
            if($fs){
                $cat = $fCatRepo->find(['id' => 1]);
                foreach ($fs as $familiar) {
                    $familiar->setfamiliarCat($cat);
                    $manager->persist($familiar);
                }
            }

            $manager->remove($f);
            $manager->flush();

            return $this->redirectToRoute('admin_familiar_list');
        }
    }
}
