<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\TransactionRepository;
use App\Repository\BankAccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transaction')]
class TransactionController extends AbstractController
{
    #[Route('/', name: 'app_transaction_index', methods: ['GET'])]
    public function index(TransactionRepository $transactionRepository): Response
    {
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactionRepository->findBy([], ['transactionDate' => 'DESC', 'id' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'app_transaction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TransactionRepository $transactionRepository, BankAccountRepository $bankAccountRepository): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction, [
            'bank_accounts' => $bankAccountRepository->findAll()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionRepository->save($transaction, true);

            $this->addFlash('success', 'Transaction created successfully!');

            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transaction/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transaction_show', methods: ['GET'])]
    public function show(Transaction $transaction): Response
    {
        return $this->render('transaction/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transaction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transaction $transaction, TransactionRepository $transactionRepository, BankAccountRepository $bankAccountRepository): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction, [
            'bank_accounts' => $bankAccountRepository->findAll()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionRepository->save($transaction, true);

            $this->addFlash('success', 'Transaction updated successfully!');

            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transaction_delete', methods: ['POST'])]
    public function delete(Request $request, Transaction $transaction, TransactionRepository $transactionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getId(), $request->request->get('_token'))) {
            $transactionRepository->remove($transaction, true);
            $this->addFlash('success', 'Transaction deleted successfully!');
        }

        return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/account/{accountId}', name: 'app_transaction_by_account', methods: ['GET'])]
    public function byAccount(int $accountId, BankAccountRepository $bankAccountRepository, TransactionRepository $transactionRepository): Response
    {
        $bankAccount = $bankAccountRepository->find($accountId);
        
        if (!$bankAccount) {
            throw $this->createNotFoundException('Bank account not found');
        }

        return $this->render('transaction/by_account.html.twig', [
            'bank_account' => $bankAccount,
            'transactions' => $transactionRepository->findByBankAccountOrderedByDate($accountId),
        ]);
    }
}