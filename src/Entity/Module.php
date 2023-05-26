<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $Nom = null;

    #[ORM\ManyToMany(targetEntity: Enseignant::class, inversedBy: 'modules')]
    private Collection $enseignant;

    #[ORM\ManyToOne(inversedBy: 'modules')]
    #[ORM\JoinColumn(nullable: false)]
    public ?Filiere $filiere = null;

    #[ORM\ManyToOne(inversedBy: 'modules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Semestre $semester = null;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: Note::class)]
    private Collection $notes;

    public function __construct()
    {
        $this->enseignant = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }public function __toString(): string
    {
        return $this->getNom(); // Replace getName() with the appropriate property or method that represents the name of the Module entity.
    }

    /**
     * @return Collection<int, Enseignant>
     */
    public function getEnseignant(): Collection
    {
        return $this->enseignant;
    }

    public function addEnseignant(Enseignant $enseignant): self
    {
        if (!$this->enseignant->contains($enseignant)) {
            $this->enseignant->add($enseignant);
        }

        return $this;
    }

    public function removeEnseignant(Enseignant $enseignant): self
    {
        $this->enseignant->removeElement($enseignant);

        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getSemester(): ?Semestre
    {
        return $this->semester;
    }

    public function setSemester(?Semestre $semester): self
    {
        $this->semester = $semester;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setModule($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getModule() === $this) {
                $note->setModule(null);
            }
        }

        return $this;
    }
}
