<?php

namespace App\Controller\eliquid;

use App\Entity\Product;
use App\Form\CreateEliquidType;
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
    #[Route('/createEliquid', name: 'createEliquid', methods: ['GET', 'POST'])]
    public function createEliquid(Request $request, ProductRepository $ProductRepository): Response
    {
        $eliquid = new Product();
        $eliquidForm = $this->createForm(CreateEliquidType::class, $eliquid);
        $eliquidForm->handleRequest($request);
        //si le form est valide et envoyé alors faire le script
        //s'il y a envoi de données et que le formulaire est valide,alors...
        if ($eliquidForm->isSubmitted() && $eliquidForm->isValid())
        {
            $img = $eliquidForm->get('img')->getData();
            //creer un id unique sou format data pour l'image
            $imgName = md5(uniqid()). '.' . $img->guessExtension();
            //mettre l'inage récupéré dans le dossier public/uploadDirectory grace aux parametres rentrés dans le service.yaml
            $img->move($this->getParameter('uploadDirectory'), $imgName);
            //ajouter l'id unique de $imgName dans le $eliquid
            $eliquid->setImg($imgName);

           // $eliquid->setDateOfCreation(new \DateTime('now'));
           // $eliquid->setDateOfUpdate(new \DateTime('now'));
            $ProductRepository->add($eliquid);
            return $this->redirectToRoute('listEliquid');
        }

        return $this->render('eliquid/createEliquid.html.twig',[
            'eliquidForm'=> $eliquidForm->createView()
        ]);
    }

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
