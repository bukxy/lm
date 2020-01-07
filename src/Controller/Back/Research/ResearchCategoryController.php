<?php

namespace App\Controller\Back\Research;

use App\Entity\ResearchCat;
use App\Form\ResearchCatType;
use App\Repository\ResearchCatRepository;

use App\Repository\ResearchRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/research-category")
*/
class ResearchCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_research_category_list")
     */
    public function list(ResearchCatRepository $c)
    {
        return $this->render('back/research/catList.html.twig', [
            'categories' => $c->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_research_category_new")
     * @Route("/edit/{id}", name="admin_research_category_edit")
     */
    public function AddEditCategory(ResearchCat $c = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$c) {
            $c = new ResearchCat();
        }

        $form = $this->createForm(ResearchCatType::class, $c);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $security->getUser();
            $c->setUser($user);
            $manager->persist($c);
            $manager->flush();
            return $this->redirectToRoute('admin_research_category_list');
        }

        return $this->render('back/research/catAddEdit.html.twig', [
            'formCat' => $form->createView(),
            'editMode'  => $c->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_research_category_delete")
     */
    public function deleteCategory(ResearchCat $c, ResearchCatRepository $cCatRepo, ResearchRepository $cRepo, EntityManagerInterface $manager, Security $security) {
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

            return $this->redirectToRoute('admin_research_list');
        }
    }
}
