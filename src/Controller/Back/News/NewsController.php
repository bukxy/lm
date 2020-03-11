<?php

namespace App\Controller\Back\News;

use App\Entity\News;
use App\Form\NewsType;
use Cocur\Slugify\Slugify;

use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_ADMIN_NEWS")
* @Route("/admin/news")
*/
class NewsController extends AbstractController
{
    /** 
    * @Route("/", name="admin_news_list")
    */
    public function list(NewsRepository $news)
    {
        return $this->render('back/news/list.html.twig', [
            'news'  => $news->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_news_new")
     * @Route("/edit/{id}", name="admin_news_edit")
     */
    public function add(News $n = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$n) {
            $n = new News();
            $user = $security->getUser();
        }

        $form = $this->createForm(NewsType::class, $n);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){

            $slugify = new Slugify();
            $n->setSlug($slugify->slugify($form['title']->getData()));

            if (!$n){
                $n->setUser($user);
            }

            if ($n->getDateCreated()) {
                $n->setDateEdit(new \DateTime());
            } else {
                $n->setDateCreated(new \DateTime());
            }

            $manager->persist($n);
            $manager->flush();
            return $this->redirectToRoute('admin_news_edit', ['id' => $n->getId()]);
        }

        return $this->render('back/news/addEdit.html.twig', [
            'form' => $form->createView(),
            'editMode'  => $n->getId() !== null,
            'news' => $n
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_news_delete")
     */
    public function delete(News $n, EntityManagerInterface $manager, Security $security) {
        if ($security->getUser()){
            $manager->remove($n);
            $manager->flush();

            return $this->redirectToRoute('admin_news_list');
        }
    }
}
