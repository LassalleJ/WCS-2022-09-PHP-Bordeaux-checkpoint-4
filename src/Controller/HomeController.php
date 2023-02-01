<?php

namespace App\Controller;

use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $manager): Response
    {
        $user=$this->getUser();
        $last3groups=$manager->getRepository(Group::class)->findby(['isFull'=>true],['id'=>'desc'],3);



        return $this->render('home/index.html.twig', [
            'last3' => $last3groups
        ]);
    }
}
