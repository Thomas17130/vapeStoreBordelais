<?php

namespace App\Controller\cart;

use App\Entity\Cart;
use App\Form\CartFormType;
use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class cartController extends AbstractController
{
    #[Route('/cart', name: 'cart', methods: ['GET','POST'])]
    public function createCart(Request $request ,CartRepository $cartRepository)
    {
        $cart = new Cart();
        $cartForm = $this->createCart(CartFormType::class, $cart);
        $cartForm->handleRequest($request);
        return $this->render('cart/cart', [
            'cart'=> $cartForm->createView(),
        ]);
    }
    #[Route('/cartView', name: 'cartView', methods: ['GET','POST'])]
    public function viewCart(CartRepository $cartRepository)
    {
        $cartRepository->get([]);

    }
    #[Route('/cart', name: 'cart', methods: ['GET','POST'])]
    public function deleteProductInCart(CartRepository $cartRepository, $id)
    {
        $cart = $cartRepository->findOneBy((['id' => $id]));
        $cartRepository->remove($cart);
        return $this->Redirecttoroute('/cart');
    }
}