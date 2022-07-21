<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class contactController extends AbstractController
{
    #[Route('contact', name: 'contact', methods: ['GET','POST'])]
    public function contact()
    {
        return $this->render('contact.html.twig');
    }
}