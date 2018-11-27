<?php

declare(strict_types=1);

namespace App\Service;


use App\Controller\RenderController;
use Swift_Mailer;
use Twig\Environment;

class Email
{
    private $mailer;

    private $twig;

    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function send(string $name,string $lastName,string $email)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('bloggerplatform@yandex.ru')
            ->setTo([$email => 'A name'])
            ->setBody(' Hi'.$name.' '.  $lastName.'! You\'re successfully registered.');

     /*   dump($this->mailer->send($message));
        die;*/
        return $this->mailer->send($message) > 0;
    }
}