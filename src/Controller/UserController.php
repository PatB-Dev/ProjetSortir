<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route(path="/profilUser", name="profil_user" ,methods={"GET"})
     */
    public function profilUser(Request $request, EntityManagerInterface $entityManager){
        $profilUser =  new User();

        $profilUserForm = $this->createForm(UserType::class, $profilUser);

        //$profilUser = $entityManager->getRepository(User::class)->find(1);


        return $this->render('user/profilUser.html.twig', ['profilUserForm'=> $profilUserForm->createView()]);

    }















    public function index(): Response {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
