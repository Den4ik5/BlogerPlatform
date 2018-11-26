<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Email;
use Swift_SmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/registration", name="registration")
     */
    public function index(Request $request)
    {
        $user= new User();
        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('name', TextType::class)
            ->add('lastName', TextType::class)
            ->add('password', PasswordType::class)
            ->add('Bloger', CheckboxType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             $user = $form->getData();
             $repository = $this->getDoctrine()->getRepository(User::class);
             $emailExist = $repository->findOneBy([
                'email' => $user->getEmail(),
             ]);
             if($emailExist){
                 echo 'Email '.$user->getEmail() .' is busy! Please use another one or log in.';
             }
             else {
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($user);
                 $entityManager->flush();

                 $email = new Email();
                 $checker = $email->send($user->getName(), $user->getLastName(), $user->getEmail(), $email->getMailer($email->getTransport()));
                 if ($checker) {
                     echo "OLL KLEAR";
                     $this->redirectToRoute('login');
                 }
             }
        }
        return $this->render('registration/new.html.twig',array(
            'form'=>$form->createView())
        );

    }
}
