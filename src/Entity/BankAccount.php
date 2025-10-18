<?php
// src/Entity/BankAccount.php

namespace App\Entity;

use App\Repository\BankAccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: BankAccountRepository::class)]
class BankAccount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bankAccounts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bank $bank = null;

    #[ORM\Column(length: 20)]
    private ?string $accountNumber = null;

    #[ORM\Column(length: 10)]
    private ?string $agency = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(type: 'decimal', precision: 15, scale: 2)]
    private ?string $balance = '0.00';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accountHolder = null;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'bankAccount')]
    private Collection $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBank(): ?Bank
    {
        return $this->bank;
    }

    public function setBank(?Bank $bank): static
    {
        $this->bank = $bank;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): static
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getAgency(): ?string
    {
        return $this->agency;
    }

    public function setAgency(string $agency): static
    {
        $this->agency = $agency;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getBalance(): string
    {
        $balance = '0.00';
        foreach ($this->transactions as $transaction) {
            if ($transaction->getType() === 'INCOME') {
                $balance = bcadd($balance, $transaction->getAmount(), 2);
            } else {
                $balance = bcsub($balance, $transaction->getAmount(), 2);
            }
        }
        return $balance;
    }

    public function setBalance(string $balance): static
    {
        $this->balance = $balance;

        return $this;
    }

    public function getAccountHolder(): ?string
    {
        return $this->accountHolder;
    }

    public function setAccountHolder(?string $accountHolder): static
    {
        $this->accountHolder = $accountHolder;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setBankAccount($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getBankAccount() === $this) {
                $transaction->setBankAccount(null);
            }
        }

        return $this;
    }
}