<?php

namespace App\Controller\box;


use App\Entity\Product;
use App\Form\CreateBoxType;
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
    #[Route('/createBox', name: 'createBox', methods:['GET','POST'])]
    public function createBox(Request $request,ProductRepository $ProductRepository): Response
    {
        $box = new Product();
        $boxForm = $this->CreateForm(CreateBoxType::class, $box);
        $boxForm->handleRequest($request);
        if ($boxForm->isSubmitted() && $boxForm->isValid()) {
            $img = $boxForm->get('img')->getData();
            $imgName = md5(uniqid()) . '.' . $img->guessExtension();
            $img->move($this->getParameter('uploadDirectory'), $imgName);
            $box->setImg($imgName);

            //$box->setDateOfCreation(new \DateTime('now'));
            //$box->setDateOfUpdate(new \DateTime('now'));
            $ProductRepository->add($box);
            return $this->redirectToRoute('listBox');
        }
        return $this->render('box/createBox.html.twig', [
            'boxForm' => $boxForm->createView()
        ]);
    }
    #[Route('/listBox', name: 'listBox', methods:['GET','POST'])]
    public function listBox(ProductRepository $productRepository)
    {
        $box = $productRepository->findBy(['category'=>2]);
        return $this->render('box/listBox.html.twig',[

            'box'=> $box
        ]);
    }

    #[Route('/showBox/{id}', name:'showBox', methods:['GET','POST'])]
    public function showBox(ProductRepository $productRepository, $id)
    {
        $box = $productRepository->findOneBy(['id'=> $id]);
        return $this->render('box/showBox.html.twig', [
            'box' => $box
        ]);
    }
}
