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
        $notif->setInvitation($invitation);
        $notif->setContent($user->getUsername() . ' applied for your group');
        $manager->persist($notif);
        $manager->flush();

        $this->addFlash('success', 'Your application has been sent to the group leader');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/accept/{id}', name: 'app_recruit')]
    public function acceptApplication(EntityManagerInterface $manager, User $user): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        } else {
            /** @var User $currentUser */
            $currentUser = $this->getUser();
        }
        $invitationRepository=$manager->getRepository(Invitation::class);
        $invitations = $invitationRepository->findBy([
            'user' => $user->getId(),
            'fromGroup' => $currentUser->getInParty()->getId()
        ]);
        foreach($invitations as $invitation) {
            $manager->getRepository(Invitation::class)->remove($invitation);
        }
        $currentUserGroup = $currentUser->getInParty();
        if (count($currentUserGroup->getCharacters()) === 5) {
            $currentUserGroup->setIsFull(true);
        }
        $userChars=$user->getCharacters();
        foreach($userChars as $char) {
            $char->setInGroup($currentUserGroup);
            $manager->persist($char);
        }
        $user->setInParty($currentUser->getInParty());
        $notification = new Notification();
        $notification->setContent($currentUser->getUsername() . ' has accepted your demand!');
        $notification->setType('Accept');
        $notification->setUser($user);
        $manager -> persist($currentUserGroup);
        $manager->persist($notification);
        $manager->persist($user);
        $manager->flush();
        $this->addFlash('success', 'You have successfully recruited a new group member !');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/reject/{id}', name: 'app_reject')]
    public function rejectApplication(EntityManagerInterface $manager, User $user): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        } else {
            /** @var User $currentUser */
            $currentUser = $this->getUser();
        }
        $invitationRepository=$manager->getRepository(Invitation::class);
        $invitations = $invitationRepository->findBy([
            'user' => $user->getId(),
            'fromGroup' => $currentUser->getInParty()->getId()
        ]);
        foreach($invitations as $invitation) {
            $manager->getRepository(Invitation::class)->remove($invitation, true);
        }

        $this->addFlash('rejection', 'You have rejected the application !');

        return $this->redirectToRoute('app_home');
    }
}
