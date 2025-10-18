<?php

namespace App\Entity;

use App\Repository\BankRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BankRepository::class)]
class Bank
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\Column(length: 18)]
    private ?string $cnpj = null;

    #[ORM\Column(length: 255)]
    private ?string $nomeEmpresarial = null;

    /**
     * @var Collection<int, BankAccount>
     */
    #[ORM\OneToMany(targetEntity: BankAccount::class, mappedBy: 'bank')]
    private Collection $bank;

    /**
     * @var Collection<int, BankAccount>
     */
    #[ORM\OneToMany(targetEntity: BankAccount::class, mappedBy: 'bank')]
    private Collection $bankAccounts;

    public function __construct()
    {
        $this->bank = new ArrayCollection();
        $this->bankAccounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): static
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    public function getNomeEmpresarial(): ?string
    {
        return $this->nomeEmpresarial;
    }

    public function setNomeEmpresarial(string $nomeEmpresarial): static
    {
        $this->nomeEmpresarial = $nomeEmpresarial;

        return $this;
    }

    /**
     * @return Collection<int, BankAccount>
     */
    public function getBank(): Collection
    {
        return $this->bank;
    }

    public function addBank(BankAccount $bank): static
    {
        if (!$this->bank->contains($bank)) {
            $this->bank->add($bank);
            $bank->setBank($this);
        }

        return $this;
    }

    public function removeBank(BankAccount $bank): static
    {
        if ($this->bank->removeElement($bank)) {
            // set the owning side to null (unless already changed)
            if ($bank->getBank() === $this) {
                $bank->setBank(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BankAccount>
     */
    public function getBankAccounts(): Collection
    {
        return $this->bankAccounts;
    }

    public function addBankAccount(BankAccount $bankAccount): static
    {
        if (!$this->bankAccounts->contains($bankAccount)) {
            $this->bankAccounts->add($bankAccount);
            $bankAccount->setBank($this);
        }

        return $this;
    }

    public function removeBankAccount(BankAccount $bankAccount): static
    {
        if ($this->bankAccounts->removeElement($bankAccount)) {
            // set the owning side to null (unless already changed)
            if ($bankAccount->getBank() === $this) {
                $bankAccount->setBank(null);
            }
        }

        return $this;
    }
}
