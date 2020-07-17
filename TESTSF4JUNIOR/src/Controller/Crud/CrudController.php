<?php

namespace App\Controller\Crud;

use App\Entity\User;
use App\Form\RegisterForm;
use App\Form\SigninForm;
use App\Form\UpdateUserForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CrudController extends AbstractController
{

/**
 * @Route("/", name="homepage")
 */

public function home()
{
  return $this->redirectToRoute("app_login");
}

/**
 * @Route("/registro", name="registro")
 */

public function registro(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncode)
{
  $form=$this->createForm(RegisterForm::class);
  $form->handleRequest($request);

   if($form->isSubmitted() && $form->isValid()){
       $user=$form->getData();
       $encryptedPassword= $passwordEncode->encodePassword($user, $user->getPassword());
       $user->setPassword($encryptedPassword);
       $registeredUser=$user;
       $em->persist($registeredUser);
       $em->flush();
       return $this->redirectToRoute("app_login");
   }

  return $this->render("crud/register.html.twig", ["registerForm"=>$form->createView()]);
}

/**
 * @Route("/users", name="users_list")
 */
public function usersList(EntityManagerInterface $em)
{
  $repository=$em->getRepository(User::class);
  $users=$repository->findAll();
  return $this->render("crud/usersList.html.twig", ["users"=>$users]);
}

/**
 * @Route("/users/{id}/delete", name="delete")
 */
public function deleteUser(User $solicitud, EntityManagerInterface $em)
{
$em->remove($solicitud);
$em->flush();
return $this->redirectToRoute("users_list");
}

/**
 * @Route("/update/{id}", name="update")
 */
public function updateUser(User $usuario, EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncode)
{
  $form=$this->createForm(UpdateUserForm::class);
  $form->handleRequest($request);

  if($form->isSubmitted() && $form->isValid()){
    $updatedUser=$form->getData();
    
    if($updatedUser['username']!=""){
      $usuario->setUsername($updatedUser['username']);
    }

    if($updatedUser['email']!=""){
      $usuario->setEmail($updatedUser['email']);
    }
    
    if($updatedUser['password']!=""){
      $encryptedPassword= $passwordEncode->encodePassword($updatedUser, $updatedUser['password']);
      $usuario->setPassword($encryptedPassword);
    }

    if($updatedUser['roles']!=""){
      $roles=[$updatedUser['roles']];
      $usuario->setRoles($roles);
    }

    if($updatedUser['comentarios']!=""){
      $usuario->setComentarios($updatedUser['comentarios']);
    }

    $em->flush();

    return $this->redirectToRoute("users_list");
  }

  return $this->render("crud/updateUserForm.html.twig", ["updateForm"=>$form->createView()]);
}


}

