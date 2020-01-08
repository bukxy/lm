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
    public function list(ResearchCatRepository $r)
    {
        return $this->render('back/research/catList.html.twig', [
            'categories' => $r->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_research_category_new")
     * @Route("/edit/{id}", name="admin_research_category_edit")
     */
    public function AddEditCategory(ResearchCat $r = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$r) {
            $r = new ResearchCat();
        }

        $form = $this->createForm(ResearchCatType::class, $r);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $security->getUser();
            $r->setUser($user);
            $manager->persist($r);
            $manager->flush();
            return $this->redirectToRoute('admin_research_category_list');
        }

        return $this->render('back/research/catAddEdit.html.twig', [
            'formCat' => $form->createView(),
            'editMode'  => $r->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_research_category_delete")
     */
    public function deleteCategory(ResearchCat $r, ResearchCatRepository $rCatRepo, ResearchRepository $rRepo, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $rs = $rRepo->findBy(['btCategory' => $r->getId()]);
        
            if($rs){
                $cat = $rCatRepo->find(['id' => 1]);
                foreach ($rs as $research) {
                    $research->setbtCategory($cat);
                    $manager->persist($research);
                }
            }

            $manager->remove($r);
            $manager->flush();

            return $this->redirectToRoute('admin_research_list');
        }
    }
}
