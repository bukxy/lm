<?php

namespace App\Controller\Back\Boost_territory;

use App\Entity\BTCategory;
use App\Form\BTCategoryType;

use App\Repository\BTCategoryRepository;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BoostTerritoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/boost-category")
*/
class BoostCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_boost_category_list")
     */
    public function listCategory(BTCategoryRepository $b)
    {
        return $this->render('back/boost/catList.html.twig', [
            'categories' => $b->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_boost_category_new")
     * @Route("/edit/{id}", name="admin_boost_category_edit")
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

        return $this->render('back/boost/catAddEdit.html.twig', [
            'formCatBoost' => $form->createView(),
            'editMode'  => $b->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_boost_category_delete")
     */
    public function deleteCategory(BTCategory $b, BTCategoryRepository $bCatRepo, BoostTerritoryRepository $bRepo, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $bts = $bRepo->findBy(['btCategory' => $b->getId()]);
        
            if($bts){
                $cat = $bCatRepo->find(['id' => 1]);
                foreach ($bts as $bt) {
                    $bt->setbtCategory($cat);
                    $manager->persist($bt);
                }
            }

            $manager->remove($b);
            $manager->flush();

            return $this->redirectToRoute('admin_boost_list');
        }
    }
}
