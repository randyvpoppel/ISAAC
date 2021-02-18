<?php
declare(strict_types=1);

namespace App\Entity;

use App\Value\PartBrand;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
final class SparePart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string|null $brand;

    /**
     * @ORM\ManyToMany(targetEntity="Model")
     * @ORM\JoinTable(name="models_spare_parts",
     *      joinColumns={@ORM\JoinColumn(name="spare_part_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="model_id", referencedColumnName="id")}
     *      )
     */
    private Collection $models;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private int $priceInCents;

    public function __construct(string $name, int $priceInCents, PartBrand $brand = null)
    {
        $this->brand = (string) $brand;
        $this->name = $name;
        $this->priceInCents = $priceInCents;

        $this->models = new ArrayCollection();
    }

    public function addModel(Model $model): void
    {
        if (!$this->models->contains($model))
        {
            $this->models->add($model);
        }
    }

    public function removeModel(Model $model): void
    {
        $this->models->remove($model);
    }

    public function getBrand(): ?PartBrand
    {
        return $this->brand ? new PartBrand($this->brand) : null;
    }

    public function getModels(): Collection
    {
        return $this->models;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPriceInCents(): int
    {
        return $this->priceInCents;
    }

    public function setPriceInCents(int $priceInCents): void
    {
        $this->priceInCents = $priceInCents;
    }
}
