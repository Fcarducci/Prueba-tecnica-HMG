<?php

namespace App\Controller\Crud;

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
    return $this->render("crud/signin.html.twig");
}

}

