<?php

namespace App\Controller\register;

use App\Controller\register\User;
use App\Form\RegistrationFormType;
use App\Form\UpdateUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/*#[Route('/admin')]*/
class userController extends AbstractController
{
    #[Route('/register', name:'register', methods:['GET','POST'])]
    public function register(Request $request, UserRepository $userRepository)
    {
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

            $userRepository->add($user);
        }
        $user = $userRepository->findBy([], ['name'=>'ASC']);
        return $this->render('registration/register.html.twig', [
            'form'=>$form->createView(),
            'user'=>$user
        ]);
    }
    //afficher un compte utilisateur sur une page
    #[Route('/myAccount', name: 'myAccount', methods: ['GET','POST'])]
    public function myAccount(UserRepository $userRepository, Request $request): Response
    {
        //$user = $userRepository->findOneBy(['id' => $id]);
        $user = $this->getUser();
        if ($user == null)
        {
          return $this->redirectToRoute('app_login');
        }
        return $this->render('security/myAccount.html.twig', ['user' => $user]);
    }

    #[Route('/updateUser/{id}', name: 'updateUser', methods: ['GET','POST'])]
        public function updateUser(UserRepository $userRepository, Request $request, $id)
    {
        $user = $userRepository->findOneBy(['id'=> $id]);
        //creation du formulaire en lien avec le $user. Tout les donnes enregistrées sont intégrées puisqu'on rapelle le formulaire et les variables deja existants
        $userForm = $this->createForm(UpdateUserType::class, $user);
        //Preparation pour l'envoi, recupere le get et le post,
        $userForm->handleRequest($request);
        //si le formulaire est envoyé et valide alors
        if($userForm->isSubmitted() && $userForm->isValid()){
            //add sait, grace a doctrine si on fait un insert ou un update
            //il s'occupe de faire les modifications BDD
            $userRepository->add($user);
            //il retourne vers une fonction qui te renvoie une autre page, myAccount
            return $this->redirectToRoute('myAccount');
        }
        return $this->render('security/updateUser.html.twig', [
            'userForm'=> $userForm->createView()
            ]);
    }


    #[Route('/deleteUser/{id}', name:'deleteUser', methods: ['GET','POST'])]
    public function deleteUser(UserRepository $userRepository, $id)
    {
        $user = $userRepository->findOneBy(['id'=>$id]);
        $userRepository->remove($user);
        $this->addFlash('success', 'Votre compte utilisateur a bien été supprimé !');
        return $this->redirectToRoute('home');
    }
}