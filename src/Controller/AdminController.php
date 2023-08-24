<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Training;
use App\Entity\User;
use App\Form\LedenUpdateType;
use App\Form\LessonType;
use App\Form\NewInstructorType;
use App\Form\TrainingType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

//    #[Route('admin/instructeur', name: 'adminInstructeur')]
//    public function showTraining(EntityManagerInterface $entityManager): Response
//    {
//
//        $users = $entityManager->getRepository(User::class)->findAll();
//
//        return $this->render('admin/trainingsvormen.html.twig', ['users' => $users]);
//    }

    #[Route('admin/training', name: 'adminTraining')]
    public function show(EntityManagerInterface $entityManager): Response
    {
        $training = $entityManager->getRepository(Training::class)->findAll();

        return $this->render('admin/trainingsvormen.html.twig', ['trainings' => $training]);
    }


    #[Route('/admin/training/insert', name: 'adminTrainingInsert')]
    public function insert(Request $request, ManagerRegistry $doctrine): Response
    {
        $training = new Training();

        $form = $this->createForm(TrainingType::class, $training);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
//            $user->setRoles(["ROLE_INSTRUCTEUR"]);
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $training = $form->getData();
            $entityManager->persist($training);

            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('adminTraining');
        }


        return $this->renderForm('admin/insert.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/update/{id}', name: 'adminTrainingUpdate')]
    public function update(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $training = $entityManager->getRepository(Training::class)->find($id);

        $form = $this->createForm(TrainingType::class, $training);
        $form->handleRequest($request);
        // dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database
            return $this->redirectToRoute('adminTraining', ['id' => $training->getId()]);
        }
        return $this->renderForm('admin/insert.html.twig',
            ['form' => $form,]);
    }

    #[Route('/admin/training/delete/{id}', name: 'adminTrainingDelete')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $training = $entityManager->getRepository(Training::class)->find($id);

        $entityManager->remove($training);
        $entityManager->flush();
        // ... perform some action, such as saving the task to the database
        return $this->redirectToRoute('adminTraining');

    }

    #[Route('admin/instructor', name: 'adminInstructor')]
    public function showInstructeur(EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findAll();

        return $this->render('admin/instructor.html.twig', ['users' => $user]);
    }

    #[Route('admin/instructor/delete/{id}', name: 'adminInstructorDelete')]
    public function deleteInstructor(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $user = $entityManager->getRepository(User::class)->find($id);

        $entityManager->remove($user);
        $entityManager->flush();
        // ... perform some action, such as saving the task to the database
        return $this->redirectToRoute('adminInstructor');

    }

    #[Route('/admin/instructor/insert', name: 'adminInstructorInsert')]
    public function newInstructor(Request $request, ManagerRegistry $doctrine,UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();

        $form = $this->createForm(NewInstructorType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $user->setPassword($passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            ));
            $user->setRoles(["ROLE_INSTRUCTEUR"]);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);

            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('adminInstructor');
        }


        return $this->renderForm('admin/insertInstructor.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('admin/leden', name: 'adminLeden')]
    public function showLeden(EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findAll();

        return $this->render('admin/leden.html.twig', ['users' => $user]);
    }

    #[Route('admin/leden/delete/{id}', name: 'adminLedenDelete')]
    public function deleteLeden(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $user = $entityManager->getRepository(User::class)->find($id);

        $entityManager->remove($user);
        $entityManager->flush();
        // ... perform some action, such as saving the task to the database
        return $this->redirectToRoute('adminLeden');
    }

    #[Route('/Leden/update/{id}', name: 'updateLeden')]
    public function updateLeden(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $leden = $entityManager->getRepository(User::class)->find($id);

        $form = $this->createForm(LedenUpdateType::class, $leden);
        $form->handleRequest($request);
        // dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database
            return $this->redirectToRoute('adminLeden');
        }
        return $this->renderForm('admin/insert.html.twig',
            ['form' => $form,]);
    }

}
