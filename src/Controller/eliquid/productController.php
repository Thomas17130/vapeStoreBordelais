<?php

namespace App\Controller\eliquid;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class productController extends AbstractController
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */

    #[Route('/listEliquid', name: 'listEliquid', methods:['GET','POST'])]
    public function listEliquid(ProductRepository $productRepository)
    {
        $eliquid = $productRepository->findBy(['category'=>2]);
        return $this->render('eliquid/listEliquid.html.twig',[

            'eliquid'=> $eliquid
        ]);
    }

    #[Route('/showEliquid/{id}', name:'showEliquid', methods:['GET','POST'])]
    public function showEliquid(ProductRepository $productRepository, $id)
    {
        $eliquid = $productRepository->findOneBy(['id'=> $id]);
        return $this->render('eliquid/showEliquid.html.twig', [
            'eliquid' => $eliquid
        ]);
    }
}
