<?php

namespace App\Entity;

use App\Repository\ReparationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use \App\Enum\DispositiveType;

#[ORM\Entity(repositoryClass: ReparationRepository::class)]
class Reparation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reparations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $id_client = null;

    #[ORM\Column(enumType: DispositiveType::class)]
    private ?DispositiveType $deviceType = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $processor = null;

    #[ORM\Column(length: 255)]
    private ?string $ram = null;

    #[ORM\Column(length: 255)]
    private ?string $storage = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $issueDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observations = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $orderDate = null;

    #[ORM\Column]
    private ?int $state = null;

    #[ORM\Column(nullable: true)]
    private ?int $valoration = null;

    #[ORM\ManyToOne(inversedBy: 'reparations')]
    private ?user $id_administrator = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdClient(): ?user
    {
        return $this->id_client;
    }

    public function setIdClient(?user $id_client): static
    {
        $this->id_client = $id_client;

        return $this;
    }

    public function getDeviceType(): ?DispositiveType
    {
        return $this->deviceType;
    }

    public function setDeviceType(DispositiveType $deviceType): static
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getProcessor(): ?string
    {
        return $this->processor;
    }

    public function setProcessor(string $processor): static
    {
        $this->processor = $processor;

        return $this;
    }

    public function getRam(): ?string
    {
        return $this->ram;
    }

    public function setRam(string $ram): static
    {
        $this->ram = $ram;

        return $this;
    }

    public function getStorage(): ?string
    {
        return $this->storage;
    }

    public function setStorage(string $storage): static
    {
        $this->storage = $storage;

        return $this;
    }

    public function getIssueDescription(): ?string
    {
        return $this->issueDescription;
    }

    public function setIssueDescription(string $issueDescription): static
    {
        $this->issueDescription = $issueDescription;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): static
    {
        $this->observations = $observations;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): static
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getValoration(): ?int
    {
        return $this->valoration;
    }

    public function setValoration(?int $valoration): static
    {
        $this->valoration = $valoration;

        return $this;
    }

    public function getIdAdministrator(): ?user
    {
        return $this->id_administrator;
    }

    public function setIdAdministrator(?user $id_administrator): static
    {
        $this->id_administrator = $id_administrator;

        return $this;
    }
}
