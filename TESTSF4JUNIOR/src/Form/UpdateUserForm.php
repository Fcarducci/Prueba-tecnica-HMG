<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder->add('username',TextType::class, ['attr' => ['placeholder' => 'Username'], 'required'=>false, 'empty_data' => '']);
      $builder->add('email', EmailType::class, ['attr' => ['placeholder' => 'Email'], 'required'=>false, 'empty_data' => '']);
      $builder->add('password', PasswordType::class, ['attr' => ['placeholder' => 'Password'], 'required'=>false, 'empty_data' => '']);
      $builder->add('roles', ChoiceType::class, ['choices'=>[
       'User'=>'ROLE_USER',
       'Admin'=>'ROLE_ADMIN'
      ]]);
      $builder->add('comentarios', TextareaType::class, ['attr' => ['placeholder' => 'Write a coment'], 'required'=>false, 'empty_data' => '']);
    }

}