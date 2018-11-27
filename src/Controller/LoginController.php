<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $user= new User();
        $form = $this->createFormBuilder($user)
            ->add('email',  EmailType::class)
            ->add('password', PasswordType::class)
            ->add('log_in', SubmitType::class, array('label' => ''))
            ->add('remember_me', CheckboxType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $repository = $this->getDoctrine()->getRepository(User::class);
            $logedIn = $repository->findOneBy([
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
            ]);

            if ($logedIn){
          //   $this->redirectToRoute('main_menu');
            }
            else{
                echo 'Incorrect email or password, please try again!';
            }
        }

        return $this->render('login/index.html.twig',array(
            'form'=>$form->createView())
        );
    }
}
