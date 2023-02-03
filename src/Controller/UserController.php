<?php

namespace App\Controller;

use App\Entity\Specificity;
use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserSpecificitiesFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
    public function edit(
        Request $request,
        User $user,
        UserRepository $userRepository,
        EntityManagerInterface $manager
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/ModifyPassword', name: 'app_user_modifyPassword', methods: ['GET', 'POST'])]
    public function editPassword(
        User $user,
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $hasher
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()['password']) === true) {
                $user->setPassword(
                    $hasher->hashPassword(
                        $user,
                        $form->getData()['newPassword']
                    )
                );
                $userRepository->save($user, true);
                $this->addFlash('success', 'le mot de passe a bien été modifié');
                return $this->redirectToRoute('app_logout');
            } else {
                $this->addFlash('alert', 'Veuillez entrée un mot de passe valide');
            }
        }

        return $this->renderForm('user/ModifyPassword.html.twig', ['form' => $form, 'user' => $user]);
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
