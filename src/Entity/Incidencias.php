<?php

namespace App\Entity;

use App\Repository\IncidenciasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IncidenciasRepository::class)]
class Incidencias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaCreacion = null;

    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    #[ORM\ManyToOne(inversedBy: 'incidencias')]
    private ?Usuario $usuario = null;

    #[ORM\ManyToOne(inversedBy: 'incidencias')]
    private ?Cliente $cliente = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fechaCreacion): static
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }
    public function __construct()
    {
        $this->fechaCreacion = new \DateTime(); 
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): static
    {
        $this->cliente = $cliente;

        return $this;
    }
}
