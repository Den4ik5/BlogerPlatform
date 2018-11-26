<?php
/**
 * Created by PhpStorm.
 * User: Den
 * Date: 26.11.2018
 * Time: 22:17
 */

namespace App\Service;


use App\Controller\RenderController;
use Swift_Mailer;
use Swift_SmtpTransport;

class Email
{
    public function getTransport(){
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465))
            ->setUsername('bloggerplatform2019')
            ->setPassword('BloggerPlatformPasswordForItransition26112018')
        ;
        return $transport;
    }

    public function getMailer($transport){
        $mailer = new Swift_Mailer($transport);
        return $mailer;
    }

    public function send(string $name,string $lastName,string $email, \Swift_Mailer $mailer){
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('bloggerplatform2019@gmail.com')
                ->setTo([$email => 'A name'])
                ->setBody(' Hi'.$name.' '.  $lastName.'! You\'re successfully registered.');
            $mailer->send($message);
            return true;
    }
}