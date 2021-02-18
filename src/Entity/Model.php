<?php
declare(strict_types=1);

namespace App\Entity;

use App\Value\CarBrand;
use Doctrine\ORM\Mapping as ORM;

/**
 * @final
 *
 * @ORM\Entity()
 */
class Model
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
    private string $brand;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    public function __construct(CarBrand $brand, string $name)
    {
        $this->brand = (string) $brand;
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): CarBrand
    {
        return new CarBrand($this->brand);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
