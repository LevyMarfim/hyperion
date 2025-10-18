<?php

namespace App\Form;

use App\Entity\Transaction;
use App\Entity\BankAccount;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bankAccount', EntityType::class, [
                'class' => BankAccount::class,
                'choice_label' => function (BankAccount $bankAccount) {
                    return $bankAccount->getBank()->getName() . ' - ' . $bankAccount->getId();
                },
                'placeholder' => 'Select a bank account',
                'attr' => [
                    'class' => 'form-select'
                ],
                'choices' => $options['bank_accounts'] ?? []
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Transaction Type',
                'choices' => [
                    'Income' => 'INCOME',
                    'Expense' => 'EXPENSE',
                ],
                'placeholder' => 'Select transaction type',
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Amount',
                'html5' => true,
                'scale' => 2,
                'attr' => [
                    'placeholder' => '0.00',
                    'step' => '0.01',
                    'min' => '0.01',
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Enter transaction description',
                    'class' => 'form-control'
                ]
            ])
            ->add('transactionDate', DateTimeType::class, [
                'label' => 'Transaction Date',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Category',
                'choices' => [
                    'Salary' => 'SALARY',
                    'Transfer' => 'TRANSFER',
                    'Food' => 'FOOD',
                    'Transport' => 'TRANSPORT',
                    'Entertainment' => 'ENTERTAINMENT',
                    'Healthcare' => 'HEALTHCARE',
                    'Education' => 'EDUCATION',
                    'Shopping' => 'SHOPPING',
                    'Bills' => 'BILLS',
                    'Other' => 'OTHER',
                ],
                'placeholder' => 'Select category',
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('recipient', TextType::class, [
                'label' => 'Recipient',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Enter recipient name',
                    'class' => 'form-control'
                ]
            ])
            ->add('sender', TextType::class, [
                'label' => 'Sender',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Enter sender name',
                    'class' => 'form-control'
                ]
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Notes',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Additional notes...',
                    'class' => 'form-control',
                    'rows' => 3
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
            'bank_accounts' => []
        ]);
    }
}