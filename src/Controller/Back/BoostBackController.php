<?php

namespace App\Controller\Back;

use App\Form\BoostTerritoryType;
use App\Form\BTCategoryType;

use App\Entity\BoostTerritory;
use App\Entity\BTCategory;
use App\Repository\BTCategoryRepository;
use App\Repository\BoostTerritoryRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BoostBackController extends AbstractController
{
    /**
     * @Route("/admin/boost", name="admin_boost_list")
     */
    public function listBoost(BoostTerritoryRepository $b)
    {
        return $this->render('back/boost/boostList.html.twig', [
            'boosts' => $b->findAll()
        ]);
    }

    /**
     * @Route("/admin/boost/new", name="admin_boost_new")
     * @Route("/admin/boost/edit/{id}", name="admin_boost_edit")
     */
    public function AddEdit(BoostTerritory $b = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$b) {
            $b = new BoostTerritory();
        }

        $form = $this->createForm(BoostTerritoryType::class, $b);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $security->getUser();
            $b->setUser($user);
            $manager->persist($b);
            $manager->flush();
            return $this->redirectToRoute('admin_boost_list');
        }

        return $this->render('back/boost/boostAddEdit.html.twig', [
            'formBoost' => $form->createView(),
            'editMode'  => $b->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/boost/delete/{id}", name="admin_boost_delete")
     */
    public function delete(BoostTerritory $b, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $manager->remove($b);
            $manager->flush();

            return $this->redirectToRoute('admin_boost_list');
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/admin/boost-category", name="admin_boost_category_list")
     */
    public function listCategory(BTCategoryRepository $b)
    {
        return $this->render('back/boost/catBoostList.html.twig', [
            'categories' => $b->findAll()
        ]);
    }

    /**
     * @Route("/admin/boost-category/new", name="admin_boost_category_new")
     * @Route("/admin/boost-category/edit/{id}", name="admin_boost_category_edit")
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
     * @Route("/admin/boost-category/delete/{id}", name="admin_boost_category_delete")
     */
    public function deleteCategory(BTCategory $b, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $manager->remove($b);
            $manager->flush();

            return $this->redirectToRoute('admin_boost_list');
        }
    }
}
