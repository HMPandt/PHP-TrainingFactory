<?php

namespace App\Controller;

use App\Entity\Training;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class  TrainingController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function show(EntityManagerInterface $entityManager): Response
    {
        $training = $entityManager->getRepository(Training::class)->findAll();

        return $this->render('training/index.html.twig', ['trainings' => $training]);
    }

    #[Route('/training/aanbod', name: 'aanbod')]
    public function showAanbod(ManagerRegistry $doctrine): Response
    {
        $trainingen = $doctrine->getRepository(Training::class)->findAll();

        // or render a template
        // in the template, print things with {{ product.name }}
         return $this->render('training/training.html.twig', ['trainingen' => $trainingen]);
    }

    #[Route('/training/aanbod-detail/{id}', name: 'detail')]
    public function showDetail(ManagerRegistry $doctrine, int $id): Response
    {
        $training = $doctrine->getRepository(Training::class)->find($id);

        // or render a template
        // in the template, print things with {{ product.name }}
        return $this->render('training/detail.html.twig', ['training' => $training]);
    }


    #[Route('/training/registeren', name: 'register')]
    public function registeren(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);


//        $hashedPassword = $passwordHasher->hashPassword(
//            $user,
//            $plaintextPassword
//        );
//        $user->setPassword($hashedPassword);


        // dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            // $plaintextPassword = User::class;
            $user = $form->getData();
            $user->setPassword($passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            ));
            $user->setRoles(["ROLE_MEMBER"]);

            $entityManager = $doctrine->getManager();
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            //dd($task);
            $entityManager->persist($user);

            $entityManager->flush();


            $this->addFlash('success', 'Jouw profile is opgeslaan!');
            // ... perform some action, such as saving the task to the database
            return $this->redirectToRoute('register');

        }

        return $this->renderForm('training/registeren.html.twig',
            ['form' => $form]);
    }

    #[Route('training/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('training/contact.html.twig', [
            'controller_name' => 'TrainingController',
        ]);
    }

    #[Route('training/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('training/login.html.twig', [
            'controller_name' => 'TrainingController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/rules', name: 'rules')]
    public function rules(): Response
    {
        return $this->render('training/rules.html.twig');
    }
  
    #[Route('/logout', name: 'logout')]
    public function logout()
    {
        // controller can be blank: it will never be called!
        return $this->redirectToRoute('home');
    }

    #[Route('/redirect', name: 'redirect')]
    public function redirectAction(Security $security)
    {
        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }
        if ($security->isGranted('ROLE_INSTRUCTEUR')) {
        return $this->redirectToRoute('instructeur');
        }
        if ($security->isGranted('ROLE_MEMBER')) {
            return $this->redirectToRoute('user');
        }

        return $this->redirectToRoute('home');
    }



}
