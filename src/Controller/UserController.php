<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Registration;
use App\Entity\Training;
use App\Entity\User;
use App\Form\EditProfileType;
use App\Form\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/profile', name: 'profile')]
    public function userProfile(): Response
    {
        return $this->render('user/profile.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/user/aanbod', name: 'aanbodLid')]
    public function showAanbod(ManagerRegistry $doctrine): Response
    {
        $trainingen = $doctrine->getRepository(Training::class)->findAll();

        // or render a template
        // in the template, print things with {{ product.name }}
        return $this->render('user/training.html.twig', ['trainingen' => $trainingen]);
    }

    #[Route('/user/aanbod-detail/{id}', name: 'detailLid')]
    public function showDetail(ManagerRegistry $doctrine, int $id): Response
    {
        $trainings = $doctrine->getRepository(Training::class)->find($id);

        // or render a template
        // in the template, print things with {{ product.name }}
        return $this->render('user/detail.html.twig', ['trainings' => $trainings]);
    }

    #[Route('/user/inschrijven/{id}', name: 'inschrijven')]
    public function enrol(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $lesson = $doctrine->getRepository(Lesson::class)->find($id);

        $registration = new Registration();
        $user = $this->getUser();
        $registration->setMember($user);
        $registration->setLesson($lesson);

        $form = $this->createForm(RegistrationType::class, $registration);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();

            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $registration = $form->getData();
            $entityManager->persist($registration);

            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('profile');
        }


        return $this->renderForm('user/inschrijven.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/user/editProfile/{id}', name: 'editProfile')]
    public function updateProfile(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->renderForm('user/editProfile.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/user/lestable', name: 'Lidlestable')]
    public function showLidLestable(): Response
    {
        $user = $this->getUser();

        return $this->render('user/lesTabel.html.twig');
    }

    #[Route('/user/delete/{id}', name: 'delete')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $lessen = $entityManager->getRepository(Registration::class)->find($id);

        $entityManager->remove($lessen);
        $entityManager->flush();
        // ... perform some action, such as saving the task to the database
        return $this->redirectToRoute('Lidlestable', ['id' => $lessen->getId()]);

    }

}
