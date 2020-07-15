<?php

namespace App\Form;

use App\Entity\Usuarios;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("username", TextType::class, array("attr"=>array("placeholder"=>"Username", "required" => true)));
        $builder->add("email", EmailType::class, array("attr"=>array("placeholder"=>"Email", "required" => true)));
        $builder->add("password", PasswordType::class, array("attr"=>array("placeholder"=>"Contraseña", "required" => true)));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(["data_class"=>Usuarios::class]);
    }
}