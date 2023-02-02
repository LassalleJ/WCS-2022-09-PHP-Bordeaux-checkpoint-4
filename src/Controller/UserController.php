<?php

namespace App\Controller;

use App\Entity\Specificity;
use App\Entity\User;
use App\Form\UserSpecificitiesFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }


    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(EntityManagerInterface $manager, User $user): Response
    {
        $userHasApplied=false;
        $currentUser = $this->getUser();
        $applies = $user->getInvitations();
        foreach($applies as $apply) {
            if($apply->getType()==='Apply') {
                foreach($apply->getFromGroup()->getUsers() as $groupMember) {
                    if($groupMember->isIsLeader() && $groupMember === $currentUser) {
                        $userHasApplied=true;
                        $apply->getNotification()->setIsSeen(true);
                        $manager->persist($apply);
                        $manager->flush();
                    }
                }
            }
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'hasApplied'=>$userHasApplied,
            'userSpecificities'=>$user->getSpecificity(),
            'userCharacters'=>$user->getCharacters(),
            'userGroup'=>$user->getInParty(),
        ]);
    }

    #[Route('/specificities', name: 'app_user_specificities')]
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

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

}
