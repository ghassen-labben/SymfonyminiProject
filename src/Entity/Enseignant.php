<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignantRepository::class)]
class Enseignant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Nom = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $preNom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Email = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $CIN = null;

    #[ORM\ManyToMany(targetEntity: Module::class, mappedBy: 'enseignant')]
    private Collection $modules;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString(): string
    {
        return $this->getNom(); // Replace getName() with the appropriate property or method that represents the name of the Etudiant entity.
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPreNom(): ?string
    {
        return $this->preNom;
    }

    public function setPreNom(?string $preNom): self
    {
        $this->preNom = $preNom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getCIN(): ?string
    {
        return $this->CIN;
    }

    public function setCIN(?string $CIN): self
    {
        $this->CIN = $CIN;

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules->add($module);
            $module->addEnseignant($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->removeElement($module)) {
            $module->removeEnseignant($this);
        }

        return $this;
    }
}
