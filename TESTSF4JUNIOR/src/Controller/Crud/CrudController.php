<?php

namespace App\Controller\Crud;

use App\Entity\User;
use App\Form\RegisterForm;
use App\Form\UpdateUserForm;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//Clase CrudController en donde se desarrola toda la funcionalidad de la aplicacion web.
class CrudController extends AbstractController
{

// Redireccion a la ruta con nombre "app_login"
/**
 * @Route("/", name="homepage")
 */

public function home()
{
  return $this->redirectToRoute("app_login");
}


// Ruta a la pagina de registro de usuarios con su correspondiente controlador.
/**
 * @Route("/registro", name="registro")
 * @IsGranted("ROLE_ADMIN")
 */

public function registro(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncode)
{
  $form=$this->createForm(RegisterForm::class);
  $form->handleRequest($request);

   if($form->isSubmitted() && $form->isValid()){
    try{
      $user=$form->getData();
      $encryptedPassword= $passwordEncode->encodePassword($user, $user->getPassword());
      $user->setPassword($encryptedPassword);
      $registeredUser=$user;
      $em->persist($registeredUser);
      $em->flush();
      return $this->redirectToRoute("users_list");
    }catch(\Exception $th){
      $this->addFlash('error', 'Existing email, try another');
    }

   }

  return $this->render("crud/register.html.twig", ["registerForm"=>$form->createView()]);
}

// Ruta a la pagina de usuarios registrados con su correspondiente controlador.
/**
 * @Route("/users", name="users_list")
 */
public function usersList(EntityManagerInterface $em)
{
  $repository=$em->getRepository(User::class);
  $users=$repository->findAll();
  return $this->render("crud/usersList.html.twig", ["users"=>$users]);
}

// Ruta y Controlador para eliminar Usuarios de la base de dato segun el id del usuario seleccionado.
/**
 * @Route("/users/{id}/delete", name="delete")
 * @IsGranted("ROLE_ADMIN")
 */
public function deleteUser(User $solicitud, EntityManagerInterface $em)
{
$em->remove($solicitud);
$em->flush();
return $this->redirectToRoute("users_list");
}

// Ruta y Controlador para actualizar Usuarios de la base de dato segun el id del usuario seleccionado.
/**
 * @Route("/update/{id}", name="update")
 * @IsGranted("ROLE_ADMIN")
 */
public function updateUser(User $usuario, EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncode)
{
  $form=$this->createForm(UpdateUserForm::class);
  $form->handleRequest($request);

  if($form->isSubmitted() && $form->isValid()){

    $updatedUser=$form->getData();
    
    if($updatedUser['username']){
      $usuario->setUsername($updatedUser['username']);
    }

    if($updatedUser['email']){
      $usuario->setEmail($updatedUser['email']);
    }
    
    if($updatedUser['password']){
      $encryptedPassword= $passwordEncode->encodePassword($usuario, $updatedUser['password']);
      $usuario->setPassword($encryptedPassword);
    }

    if($updatedUser['roles']){
      $roles=[$updatedUser['roles']];
      $usuario->setRoles($roles);
    }

    if($updatedUser['comentarios']){
      $usuario->setComentarios($updatedUser['comentarios']);
    }

    $em->flush();

    return $this->redirectToRoute("users_list");
  }

  return $this->render("crud/updateUserForm.html.twig", ["updateForm"=>$form->createView()]);
}


}

