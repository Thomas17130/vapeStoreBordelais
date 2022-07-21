<?php

namespace App\Controller;


use App\Form\ContactForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class contactController extends AbstractController
{
    #[Route('/contact', name: 'contact', methods: ['GET','POST'])]
    public function contact(Request $request, MailerInterface $mailer)
    {
        $contactForm = $this->createForm(ContactForm::class);

        if($contactForm->isSubmitted() && $contactForm->isValid()){
            sendEmail($request->request->get('email'),$request->request->get('title'),$request->request->get('message'), $mailer);
        }

        return $this->render('contact.html.twig', [
            'contactForm' => $contactForm->createView()
        ]);
    }

    public function sendEmail($destEmail, $title, $message, $mailer)
    {
        $email = (new Email())
            ->from('thomasguillemette06@gmail.com')
            ->to($destEmail)
            ->subject($title)
            ->text($message);

        $mailer->send($email);
    }

    #[Route('/sendmail',name:'sendmail')]
    public function sendmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('thomasguillemette06@gmail.com')
            ->to('younes.benmeuraiem7@gmail.com')
            ->subject('Toto le gros zozo')
            ->text('Si tu perd le message, alors t\'est con');

        $mailer->send($email);

        return new Response(200);
    }
}