<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   $today=new Date();
        $today=\date('Y');
        $today=intval($today);
        $today=$today-18;
        $today=strval($today);
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('mail')
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('dateDeNaissance' ,DateType::class,[
    'format'=>'dd MM y',

    // prevents rendering it as type="date", to avoid HTML5 date pickers
    'html5' => false, 'years'=>range(1950,$today,1),

    // adds a class that can be selected in JavaScript
    'attr' => ['class' => 'js-datepicker'],]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
