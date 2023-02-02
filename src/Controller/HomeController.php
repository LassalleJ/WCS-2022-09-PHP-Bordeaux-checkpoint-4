<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $manager): Response
    {
        $userGroup = null;
        if ($this->getUser()) {
            /** @var User $user */
            $user=$this->getUser();
            $userGroup = $user->getInParty();
        }

        $roles=[];
        $last3groups=$manager->getRepository(Group::class)->findby(['isFull'=>true],['id'=>'desc'],3);
        $lookForLast = $manager->getRepository(Group::class)->getLastUncompleteGroups();


        return $this->render('home/index.html.twig', [
            'last3' => $last3groups,
            'lookForLast' => $lookForLast,
            'userGroup' => $userGroup,
        ]);
    }
}
