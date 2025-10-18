<?php

namespace App\Form;

use App\Entity\Bank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BankType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Bank Name',
                'attr' => [
                    'placeholder' => 'Enter bank name',
                    'class' => 'form-control'
                ]
            ])
            ->add('cnpj', TextType::class, [
                'label' => 'CNPJ',
                'attr' => [
                    'placeholder' => '00.000.000/0000-00',
                    'class' => 'form-control cnpj-mask'
                ]
            ])
            ->add('nomeEmpresarial', TextType::class, [
                'label' => 'Corporate Name',
                'attr' => [
                    'placeholder' => 'Enter full corporate name',
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bank::class,
        ]);
    }
}