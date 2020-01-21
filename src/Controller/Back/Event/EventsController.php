<?php

namespace App\Controller\Back\Event;

use App\Entity\Events;
use App\Form\EventsType;

use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ResearchRepository;
use App\Repository\ResearchCatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* @IsGranted("ROLE_ADMIN_EVENTS")
* @Route("/admin/event")
*/
class EventsController extends AbstractController
{
    /**
     * @Route("/edit/{id}", name="admin_event_edit")
     */
    public function edit(Events $e = null, Request $req, EntityManagerInterface $manager, Security $security)
    {
        if (!$e) {
            $e = new Events();
        }

        $form = $this->createForm(EventsType::class, $e);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()){

            $user = $security->getUser();

            $e->setUser($user);
            $manager->persist($e);
            $manager->flush();
            return $this->redirectToRoute('admin_event_edit', ['id' => $e->getId()]);
        }

        return $this->render('back/event/addEdit.html.twig', [
            'form' => $form->createView(),
            'editMode'  => $e->getId() !== null,
            'event' => $e
        ]);
    }

    // /**
    //  * @Route("/delete/{id}", name="admin_research_delete")
    //  */
    // public function delete(Events $r, EntityManagerInterface $manager, Security $security) {
    //     if ($security->getUser()){
    //         $manager->remove($r);
    //         $manager->flush();

    //         return $this->redirectToRoute('admin_event_list');
    //     }
    // }
}
