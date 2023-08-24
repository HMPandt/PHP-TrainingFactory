<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Registration;
use App\Entity\Training;
use App\Entity\User;
use App\Form\EditProfileType;
use App\Form\LessonType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstructeurController extends AbstractController
{
    #[Route('/instructeur', name: 'instructeur')]

    public function index(): Response
    {
//        $this->getUser();
        return $this->render('instructeur/index.html.twig', [
            'controller_name' => 'InstructeurController',
        ]);
    }
    #[Route('/instructeur/lestable', name: 'lestable')]
    public function showLestable(ManagerRegistry $doctrine): Response
    {

        $lessons = $doctrine->getRepository(Lesson::class)->findAll();

        return $this->render('instructeur/lestable.html.twig', ['lessons' => $lessons]);
    }

    #[Route('/instructeur/detail/{id}', name: 'details')]
    public function showDets(ManagerRegistry $doctrine, int $id): Response
    {

        $lesson = $doctrine->getRepository(Lesson::class)->find($id);

        return $this->render('instructeur/detail.html.twig', ['lesson' => $lesson]);
    }

    #[Route('/instructeur/deelnemers/{id}', name: 'deelnemers')]
    public function showDeelnemers(ManagerRegistry $doctrine, int $id): Response
    {
        $lesson= $doctrine->getRepository(Lesson::class)->find($id);

        return $this->render('instructeur/deelnemerslijst.html.twig', ['lesson' => $lesson]);
    }

    #[Route('/instructeur/insert', name: 'insert')]
    public function insert(Request $request, ManagerRegistry $doctrine): Response
    {
        $lesson = new Lesson();
        $user = $this->getUser();
        $lesson->setInstructeur($user);
        $form = $this->createForm(LessonType::class, $lesson);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();

            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $lesson = $form->getData();
            $entityManager->persist($lesson);

            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('lestable');
        }


        return $this->renderForm('instructeur/insert.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/instructeur/update/{id}', name: 'update')]
    public function update(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $lessen = $entityManager->getRepository(Lesson::class)->find($id);

        $form = $this->createForm(LessonType::class, $lessen);
        $form->handleRequest($request);
        // dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database
            return $this->redirectToRoute('lestable', ['id' => $lessen->getId()]);
        }
        return $this->renderForm('instructeur/update.html.twig',
            ['form' => $form,]);
    }
    #[Route('/instructeur/delete/{id}', name: 'delete')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $lessen = $entityManager->getRepository(Lesson::class)->find($id);

        $entityManager->remove($lessen);
        $entityManager->flush();
        // ... perform some action, such as saving the task to the database
        return $this->redirectToRoute('lestable', ['id' => $lessen->getId()]);

    }

    #[Route('/instructeur/profiel', name: 'profiel')]
    public function showProfile(): Response
    {
        return $this->render('instructeur/profiel.html.twig', [
            'controller_name' => 'InstructeurController',
        ]);
    }

    #[Route('profile', name: 'profiel')]
    public function userProfile(): Response
    {
        return $this->render('instructeur/profiel.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/editProfile/{id}', name: 'editProfiel')]
    public function updateProfile(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('profiel');
        }

        return $this->renderForm('instructeur/editProfiel.html.twig', [
            'form' => $form,
        ]);
    }


}
