<?php
/**
 * Created by PhpStorm.
 * User: Den
 * Date: 27.11.2018
 * Time: 1:24
 */

namespace App\Service;


class CheckInDatabase
{
    public function isEmailTaken($usersEmail){
        $repository = $this->getDoctrine()->getRepository(User::class);
        $logedIn = $repository->findOneBy([
            'email' => $usersEmail,
            'password' => $usersPassword,
        ]);

        if ($logedIn){
            return $this->render('registration/new.html.twig',array(
                    'form'=>$form->createView())
            );
        }


    }
}