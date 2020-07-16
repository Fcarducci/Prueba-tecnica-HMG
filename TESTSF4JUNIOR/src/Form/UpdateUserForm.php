<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
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
      $builder->add('username',TextType::class, array('attr' => array('placeholder' => 'Francesco Carducci', 'label'=>'Nombre')));
      $builder->add('email', EmailType::class, ['choices' => ['Madrid' => 'Madrid','Sevilla' => 'Sevilla','Barcelona' => 'Barcelona'],'placeholder' => 'Elige la ciudad', 'label'=>'Ciudad']);
      $builder->add('password', PasswordType::class, array('attr' => array('placeholder' => 'Escribe un coementario', 'label'=>'Comentario')));
      $builder->add('comentario', TextareaType::class, array('attr' => array('placeholder' => 'Escribe un coementario', 'label'=>'Comentario')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults(['data_class' => User::class]);
    }
}