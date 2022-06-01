<?php

namespace App\Controller\basket;

use App\Entity\Basket;
use App\Form\BasketFormType;
use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class basketController extends AbstractController
{
    #[Route('/basket', name: 'basket', methods: ['GET','POST'])]
    public function createBasket(Request $request ,BasketRepository $basketRepository)
    {
        $basket = new Basket();
        $basketForm = $this->createBasket(BasketFormType::class, $basket);
        $basketForm->handleRequest($request);

    }
    #[Route('/basket', name: 'basket', methods: ['GET','POST'])]
    public function viewBasket(BasketRepository $basketRepository, $box, $eliquid )
    {
        $basket = $basketRepository->get([
            'box'=> $box,
            'eliquid'=>$eliquid
        ]);
    }
    #[Route('/basket', name: 'basket', methods: ['GET','POST'])]
    public function deleteProductInBasket(BasketRepository $basketRepository, $id)
    {
        $basket = $basketRepository->findOneBy((['id' => $id]));
        $basketRepository->remove($basket);
        return $this->Redirecttoroute('');
    }
}