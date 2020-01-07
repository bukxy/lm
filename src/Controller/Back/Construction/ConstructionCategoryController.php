<?php

namespace App\Controller\Back\Construction;

use App\Entity\ConstructionCat;
use App\Form\ConstructionCatType;
use App\Repository\ConstructionCatRepository;

use App\Repository\ConstructionRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/construction-category")
*/
class ConstructionCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_construction_category_list")
     */
    public function list(ConstructionCatRepository $c)
    {
        return $this->render('back/construction/catList.html.twig', [
            'categories' => $c->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_construction_category_new")
     * @Route("/edit/{id}", name="admin_construction_category_edit")
     */
    public function AddEditCategory(ConstructionCat $c = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$c) {
            $c = new ConstructionCat();
        }

        $form = $this->createForm(ConstructionCatType::class, $c);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $security->getUser();
            $c->setUser($user);
            $manager->persist($c);
            $manager->flush();
            return $this->redirectToRoute('admin_construction_category_list');
        }

        return $this->render('back/construction/catAddEdit.html.twig', [
            'formCat' => $form->createView(),
            'editMode'  => $c->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_construction_category_delete")
     */
    public function deleteCategory(ConstructionCat $c, ConstructionCatRepository $cCatRepo, ConstructionRepository $cRepo, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $cts = $cRepo->findBy(['btCategory' => $c->getId()]);
        
            if($cts){
                $cat = $cCatRepo->find(['id' => 1]);
                foreach ($cts as $ct) {
                    $ct->setbtCategory($cat);
                    $manager->persist($ct);
                }
            }

            $manager->remove($c);
            $manager->flush();

            return $this->redirectToRoute('admin_construction_list');
        }
    }
}
