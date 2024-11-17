<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomd = null;

    #[ORM\Column(length: 255)]
    private ?string $resp = null;

    #[ORM\Column]
    private ?int $nbrs = null;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: Employee::class)]
    private Collection $Employee;

    public function __construct()
    {
        $this->Employee = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomd(): ?string
    {
        return $this->nomd;
    }

    public function setNomd(string $nomd): static
    {
        $this->nomd = $nomd;

        return $this;
    }

    public function getResp(): ?string
    {
        return $this->resp;
    }

    public function setResp(string $resp): static
    {
        $this->resp = $resp;

        return $this;
    }

    public function getNbrs(): ?int
    {
        return $this->nbrs;
    }

    public function setNbrs(int $nbrs): static
    {
        $this->nbrs = $nbrs;

        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployee(): Collection
    {
        return $this->Employee;
    }

    public function addEmployee(Employee $employee): static
    {
        if (!$this->Employee->contains($employee)) {
            $this->Employee->add($employee);
            $employee->setDepartement($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): static
    {
        if ($this->Employee->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getDepartement() === $this) {
                $employee->setDepartement(null);
            }
        }

        return $this;
    }
}
