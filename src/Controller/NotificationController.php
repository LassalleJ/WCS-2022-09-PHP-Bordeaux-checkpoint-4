<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification_show')]
    public function index(EntityManagerInterface $manager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        } else {
            /** @var User $user */
            $user = $this->getUser();
        }
        $notifs = $manager->getRepository(Notification::class)->findBy(
            ['user'=>$user->getId(),
                'isSeen' => false,
                ]);
        $applyNotifs=[];
        $invitNotifs=[];
        foreach($notifs as  $notif) {
            if($notif->getType() === 'Apply') {
                $applyNotifs[]=$notif;
            } elseif ($notif->getType()==='Invitation') {
                $invitNotifs[]=$notif;
            }
        }

        return $this->render('notification/notifications.html.twig', [
            'applyNotifs' => $applyNotifs,
            'invitNotifs' => $invitNotifs,
        ]);
    }
}
