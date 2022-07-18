<?php

namespace App\Controller\box;

use App\Entity\BoxProducts;
use App\Form\CreateBoxType;
use App\Repository\BoxProductsRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class boxController extends AbstractController
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/createBox', name: 'createBox', methods:['GET','POST'])]
    public function createBox(Request $request,BoxProductsRepository $boxProductsRepository): Response
    {
        $box = new BoxProducts();
        $boxForm = $this->CreateForm(CreateBoxType::class, $box);
        $boxForm->handleRequest($request);
        if($boxForm->isSubmitted() && $boxForm->isValid())
        {
            $img = $boxForm->get('img')->getData();
            $imgName = md5(uniqid()) . '.' .$img->guessExtension();
            $img->move($this->getParameter('uploadDirectory'), $imgName);
            $box->setImg($imgName);

            $box->setDateOfCreation(new \DateTime('now'));
            $box->setDateOfUpdate(new \DateTime('now'));
            $boxProductsRepository->add($box);
            return $this->redirectToRoute('listBox');
        }
        return $this->render('box/createBox.html.twig',[
            'boxForm'=> $boxForm->createView()
        ]);
    }
    #[Route('/listBox', name: 'listBox', methods:['GET','POST'])]
    public function listBox(BoxProductsRepository $boxProductsRepository)
    {
        $boxs = $boxProductsRepository->findAll();
        return $this->render('box/listBox.html.twig',[
            'boxs'=> $boxs
        ]);
    }
    #[Route('/showBox/{id}', name:'showBox', methods:['GET','POST'])]
    public function showBox(BoxProductsRepository $boxProductsRepository, $id)
    {
        $box = $boxProductsRepository->findOneBy(['id'=> $id]);
        return $this->render('box/showBox.html.twig', [
            'box' => $box
        ]);
    }
    #[Route('/updateBox/{id}', name:'updateBox', methods:['GET','POST'])]
    public function updateBox(Request $request, BoxProductsRepository $boxProductsRepository, $id)
    {
        $box = $boxProductsRepository->findOneBy(['id'=>$id]);
        $boxForm = $this->createForm(CreateBoxType::class, $box);
        $boxForm->handleRequest($request);
        if($boxForm->isSubmitted() && $boxForm->isValid())
        {
            if($boxForm->get('img')->getData() !== null)
            {
                $img = $boxForm->get('img')->getData();
                $imgName = md5(uniqid() . '.' . $img->guessExtension());
                $img->move($this->getParameter('uploadDirectory'), $imgName);
                $box->setImg($imgName);
            }
            $boxProductsRepository->add($box);
            return $this->RedirectToRoute('listBox');
        }
        return $this->render('box/updateBox.html.twig',[
            'boxForm'=>$boxForm->createView(),
            'id' =>$box->getId()
        ]);
    }
    #[Route('/deleteBox/{id}', name:'deleteBox', methods:['GET','POST'])]
    public function deleteBox(BoxProductsRepository $boxProductsRepository, $id)
    {
        $box = $boxProductsRepository->findOneBy((['id' => $id]));
        $boxProductsRepository->remove($box);
        return $this->Redirecttoroute('listBox');
    }
}