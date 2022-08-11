<?php
namespace App\ServiceMailler;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class MaillerService  
{
   
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
        // $this->twig=$twig;
    }
    public function sendEmail($client,$nom)
    {
        $email = (new Email())
            ->from('brasil@keurMassar.com')
            ->to($client)
            ->subject('M/Mme'.' '.$nom.' '.'Votre commande a été envoyer avec succés')
            ;
            // ->text('Sending emails is fun again!')
            // ->html('<p>See Twig integration for better HTML integration!</p>');
            $this->mailer->send($email);

        
    }
}
