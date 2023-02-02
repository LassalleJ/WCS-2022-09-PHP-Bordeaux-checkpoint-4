<?php

namespace App\Controller;

use App\Entity\Specificity;
use App\Entity\User;
use App\Form\UserSpecificitiesFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/specificities', name: 'app_user_specificities')]
    public function saveSpecificities(Request $request, EntityManagerInterface $manager)
    {
        $user=$this->getUser();
        $form=$this->createForm(UserSpecificitiesFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $userSpecificities = new Specificity();
            $userSpecificities=$form->getData();
            $userSpecificities->setUser($user);
            $manager->persist($userSpecificities);
            $manager->flush();
            return $this->redirectToRoute('app_home');

        }
        return $this->render('user/specificities.html.twig', [
            'form'=>$form->createView()
        ]);
    }

}
