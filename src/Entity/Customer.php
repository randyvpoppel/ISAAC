<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @final
 *
 * @ORM\Entity()
 */
class Customer
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
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $contact;

    /**
     * @ORM\OneToMany(targetEntity="Car", mappedBy="customer")
     */
    private Collection $cars;

    public function __construct(string $firstName, string $lastName, string $contact)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->contact = $contact;

        $this->cars = new ArrayCollection();
    }

    public function addCar(Car $car): void
    {
        if (!$this->cars->contains($car))
        {
            $this->cars->add($car);
        }
    }

    public function removeCar(Car $car): void
    {
        $this->cars->remove($car);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getContact(): string
    {
        return $this->contact;
    }

    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function setContact(string $contact): void
    {
        $this->contact = $contact;
    }
}
