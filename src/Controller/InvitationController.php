<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Invitation;
use App\Entity\Notification;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvitationController extends AbstractController
{
    #[Route('/invitation', name: 'app_invitation')]
    public function index(): Response
    {
        return $this->render('invitation/index.html.twig', [
            'controller_name' => 'InvitationController',
        ]);
    }

    #[Route('/apply/{id}', name: 'app_apply')]
    public function applyToGroup(EntityManagerInterface $manager, Group $group): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        } else {
            /** @var User $user */
            $user = $this->getUser();
        }
        $invitation = new Invitation();
        $invitation->setUser($user);
        $invitation->setType("Apply");
        $invitation->setFromGroup($group);
        $manager->persist($invitation);
        $groupMembers = $group->getUsers();
        foreach ($groupMembers as $member) {
            if ($member->isIsLeader() === true) {
                $groupLeader = $member;
            }
        }
        $notif = new Notification();
        $notif->setType("Apply");
        $notif->setUser($groupLeader);
        $notif->setContent($user->getUsername() . ' wants to join your group');
        $manager->persist($notif);

        $manager->flush();

        $this->addFlash('success', 'Your application has been sent to the group leader');

        return $this->redirectToRoute('app_home');
    }
}
