<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, [
                'attr'=>[
                    'class'=>'form form-control'
                ]
            ])
            ->add('LastName', null, [
                'attr'=>[
                    'class'=>'form form-control'
                ]
            ])
            ->add('phone', null, [
                'attr'=>[
                    'class'=>'form form-control'
                ]
            ])
            ->add('adresse', null, [
                'attr'=>[
                    'class'=>'form form-control'
                ]
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'attr'=>[
                    'class'=>'form form-control'
                ]
            ])
            ->add('payOnDelivery', null, [
                'label'=>'Payer en magasin'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
