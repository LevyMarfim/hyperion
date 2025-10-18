<?php

namespace App\Form;

use App\Entity\BankAccount;
use App\Entity\Bank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class BankAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bank', EntityType::class, [
                'class' => Bank::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a bank',
                'attr' => [
                    'class' => 'form-select'
                ],
                'choices' => $options['banks'] ?? []
            ])
            ->add('accountNumber', TextType::class, [
                'label' => 'Account Number',
                'attr' => [
                    'placeholder' => 'Enter account number',
                    'class' => 'form-control'
                ]
            ])
            ->add('agency', TextType::class, [
                'label' => 'Agency',
                'attr' => [
                    'placeholder' => 'Enter agency number',
                    'class' => 'form-control'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Account Type',
                'choices' => [
                    'Checking Account' => 'CHECKING',
                    'Savings Account' => 'SAVINGS',
                    'Salary Account' => 'SALARY',
                    'Business Account' => 'BUSINESS',
                ],
                'placeholder' => 'Select account type',
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('balance', NumberType::class, [
                'label' => 'Initial Balance',
                'html5' => true,
                'scale' => 2,
                'attr' => [
                    'placeholder' => '0.00',
                    'step' => '0.01',
                    'min' => '0',
                    'class' => 'form-control'
                ]
            ])
            ->add('accountHolder', TextType::class, [
                'label' => 'Account Holder',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Enter account holder name',
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BankAccount::class,
            'banks' => []
        ]);
    }
}