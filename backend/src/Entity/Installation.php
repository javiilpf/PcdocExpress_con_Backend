<?php

namespace App\Entity;

use App\Repository\InstallationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstallationRepository::class)]
class Installation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'installations')]
    private Collection $id_product;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $processor = null;

    #[ORM\Column(length: 255)]
    private ?string $ram = null;

    #[ORM\Column(length: 255)]
    private ?string $storage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $installation_Date = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    public function __construct()
    {
        $this->id_product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getIdProduct(): Collection
    {
        return $this->id_product;
    }

    public function addIdProduct(Product $idProduct): static
    {
        if (!$this->id_product->contains($idProduct)) {
            $this->id_product->add($idProduct);
        }

        return $this;
    }

    public function removeIdProduct(Product $idProduct): static
    {
        $this->id_product->removeElement($idProduct);

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

    public function getInstallationDate(): ?\DateTimeInterface
    {
        return $this->installation_Date;
    }

    public function setInstallationDate(\DateTimeInterface $installation_Date): static
    {
        $this->installation_Date = $installation_Date;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }
}
