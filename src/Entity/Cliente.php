<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apellidos = null;

    #[ORM\Column(length: 255)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $direccion = null;

    #[ORM\OneToMany(targetEntity: Incidencias::class, mappedBy: 'cliente')]
    private Collection $incidencias;

    public function __construct()
    {
        $this->incidencias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(?string $apellidos): static
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * @return Collection<int, Incidencias>
     */
    public function getIncidencias(): Collection
    {
        return $this->incidencias;
    }

    public function addIncidencia(Incidencias $incidencia): static
    {
        if (!$this->incidencias->contains($incidencia)) {
            $this->incidencias->add($incidencia);
            $incidencia->setCliente($this);
        }

        return $this;
    }

    public function removeIncidencia(Incidencias $incidencia): static
    {
        if ($this->incidencias->removeElement($incidencia)) {
            // set the owning side to null (unless already changed)
            if ($incidencia->getCliente() === $this) {
                $incidencia->setCliente(null);
            }
        }

        return $this;
    }
}
