<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\User;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/group')]
class GroupController extends AbstractController
{
    #[Route('/', name: 'app_group_index', methods: ['GET'])]
    public function index(GroupRepository $groupRepository): Response
    {
        return $this->render('group/index.html.twig', [
            'groups' => $groupRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_group_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $group = new Group();
        $group->setIsFull(false);
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($group);
            /** @var User $user */
            $user=$this->getUser();
            $user->setInParty($group);
            $user->setIsLeader(true);
            foreach($user->getCharacters() as $character) {
                $character->setInGroup($group);
            }
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('group/new.html.twig', [
            'group' => $group,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_group_show', methods: ['GET'])]
    public function show(Group $group): Response
    {
        return $this->render('group/show.html.twig', [
            'group' => $group,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_group_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Group $group, GroupRepository $groupRepository): Response
    {
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupRepository->save($group, true);

            return $this->redirectToRoute('app_group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('group/edit.html.twig', [
            'group' => $group,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_group_delete', methods: ['POST'])]
    public function delete(Request $request, Group $group, GroupRepository $groupRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$group->getId(), $request->request->get('_token'))) {
            $groupRepository->remove($group, true);
        }

        return $this->redirectToRoute('app_group_index', [], Response::HTTP_SEE_OTHER);
    }
}
