<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @final
 *
 * @ORM\Entity()
 */
class Engineer
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
     * Wage per timeslot (15 minutes) in cents
     *
     * @ORM\Column(type="integer")
     */
    private int $wage;

    public function __construct(string $firstName, string $lastName, int $wage)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->wage = $wage;
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

    public function getWage(): int
    {
        return $this->wage;
    }
}
