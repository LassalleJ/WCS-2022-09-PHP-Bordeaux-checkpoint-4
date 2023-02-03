<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/notification')]
class NotificationController extends AbstractController
{
    #[Route('/', name: 'app_notification_show')]
    public function index(EntityManagerInterface $manager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        } else {
            /** @var User $user */
            $user = $this->getUser();
        }
        $notifs = $manager->getRepository(Notification::class)->findBy(
            ['user' => $user->getId(),
                'isSeen' => false,
            ]);
        $applyNotifs = [];
        $invitNotifs = [];
        $acceptNotifs = [];
        $rejectNotifs = [];

        foreach ($notifs as $notif) {
            if ($notif->getType() === 'Apply') {
                $applyNotifs[] = $notif;
            } elseif ($notif->getType() === 'Invitation') {
                $invitNotifs[] = $notif;
            } elseif ($notif->getType() === 'Accept') {
                $acceptNotifs[] = $notif;
            } elseif ($notif->getType() === 'Reject') {
                $rejectNotifs[] = $notif;
            }
        }

        return $this->render('notification/notifications.html.twig', [
            'applyNotifs' => $applyNotifs,
            'invitNotifs' => $invitNotifs,
            'acceptNotifs' => $acceptNotifs,
            'rejectNotifs' => $rejectNotifs,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_notification_delete')]
    public function deleteNotification(EntityManagerInterface $manager, Notification $notification): Response
    {
        $manager->getRepository(Notification::class)->remove($notification, true);

        return $this->redirectToRoute('app_notification_show');
    }
}
