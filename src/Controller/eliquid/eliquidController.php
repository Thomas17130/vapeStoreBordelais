<?php

namespace App\Controller\eliquid;

use App\Entity\EliquidProducts;
use App\Form\CreateEliquidType;
use App\Repository\EliquidProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class eliquidController extends AbstractController
{
    #[Route('/createEliquid', name: 'createEliquid', methods: ['GET', 'POST'])]
    public function createEliquid(Request $request, EliquidProductsRepository $eliquidProductsRepository): Response
    {
        $eliquid = new EliquidProducts();
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

            $eliquid->setDateOfCreation(new \DateTime('now'));
            $eliquid->setDateOfUpdate(new \DateTime('now'));
            $eliquidProductsRepository->add($eliquid);
            return $this->redirectToRoute('listEliquid');
        }

        return $this->render('eliquid/createEliquid.html.twig',[
            'eliquidForm'=> $eliquidForm->createView()
        ]);
    }

    #[Route('/listEliquid', name: 'listEliquid', methods: ['GET', 'POST'])]
    public function listEliquid(EliquidProductsRepository $eliquidProductsRepository)
    {
        $eliquidActive = $eliquidProductsRepository->isInStock(0);
        $eliquidUnactive = $eliquidProductsRepository->findBy(['stock'=> 0]);
        //render permet d envoyer des informations dans le twig, donc dans le view
        return $this->render('eliquid/listEliquid.html.twig', [
            'eliquidActive' => $eliquidActive,
            'eliquidUnactive' => $eliquidUnactive
        ]);
    }


    #[Route('/showEliquid/{id}', name:'showEliquid', methods:['GET','POST'])]
    public function showEliquid(EliquidProductsRepository $eliquidProductsRepository, $id)
    {
        $eliquid = $eliquidProductsRepository->FindOneBy(['id' =>$id]);
        return  $this->render('eliquid/showEliquid.html.twig', [
            'eliquid' => $eliquid
        ]);
    }

    #[Route('/updateEliquid/{id}', name:'updateEliquid', methods:['GET','POST'])]
    public function updateEliquid(Request $request, EliquidProductsRepository $eliquidProductsRepository, $id)
    {
        $eliquid = $eliquidProductsRepository->FindOneBy(['id' =>$id]);
        $eliquidForm = $this->createForm(CreateEliquidType::class, $eliquid);
        $eliquidForm->handleRequest($request);
        if ($eliquidForm->isSubmitted() && $eliquidForm->isValid())
        {

            if($eliquidForm->get('img')->getData() !== null){
                $img = $eliquidForm->get('img')->getData();
                //creer un id unique sous format data pour l'image
                $imgName = md5(uniqid()). '.' . $img->guessExtension();
                //mettre l'image récupéré dans le dossier public/uploadDirectory grace aux parametres rentrés dans le service.yaml
                $img->move($this->getParameter('uploadDirectory'), $imgName);
                //ajouter l'id unique de $imgName dans le $eliquid
                $eliquid->setImg($imgName);
            }

            $eliquidProductsRepository->add($eliquid);
            return $this->RedirectToRoute('listEliquid');
            }
        return $this->render('eliquid/updateEliquid.html.twig',[
            'eliquidForm'=>$eliquidForm->createView(),
            'id' => $eliquid->getId()
        ]);
    }
    #[Route('/deleteEliquid/{id}', name:'deleteEliquid', methods:['GET','POST'])]
    public function deleteEliquid(EliquidProductsRepository $eliquidProductsRepository, $id)
    {
        $eliquid = $eliquidProductsRepository->findOneBy(['id' => $id]);
        $eliquidProductsRepository->remove($eliquid);
        return $this->RedirectToRoute('listEliquid');
    }
}
