<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class homeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET','POST'])]
    public function home()
    {
        return $this->render('home.html.twig');
    }
}