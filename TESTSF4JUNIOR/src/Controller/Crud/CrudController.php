<?php

namespace App\Controller\Crud;

use App\Form\RegisterForm;
use App\Form\SigninForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrudController extends AbstractController
{

/**
 * @Route("/", name="homepage")
 */

public function home()
{
    $form=$this->createForm(SigninForm::class);

    return $this->render("crud/signin.html.twig", ["signinForm"=>$form->createView()]);
}

/**
 * @Route("/registro", name="registro")
 */

public function registro()
{
  $form=$this->createForm(RegisterForm::class);

  return $this->render("crud/register.html.twig", ["registerForm"=>$form->createView()]);
}

}

