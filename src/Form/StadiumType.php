<?php

namespace App\Form;

use App\Entity\Stadium;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class StadiumType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
    $resolver->setDefaults([
        'csrf_protection' => true,
        'csrf_field_name' => '_token',
        'csrf_token_id'   => 'form_intention',
        'data_class' => Stadium::class,
    ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address')
            ->add('number_of_seats')
            ->add('version', HiddenType::class)
        ;
    }
}
