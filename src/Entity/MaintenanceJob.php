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
class MaintenanceJob
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * Each time slot is 15 minutes
     * @ORM\Column(type="integer")
     */
    private int $amountOfTimeSlots;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $description;

    /**
     * @ORM\ManyToMany(targetEntity="SparePart")
     * @ORM\JoinTable(name="maintenance_jobs_spare_parts",
     *      joinColumns={@ORM\JoinColumn(name="maintenance_job_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="spare_part_id", referencedColumnName="id")}
     *      )
     */
    private Collection $spareParts;

    public function __construct(int $amountOfTimeSlots, string $description)
    {
        $this->amountOfTimeSlots = $amountOfTimeSlots;
        $this->description = $description;

        $this->spareParts = new ArrayCollection();
    }

    public function addSparePart(SparePart $sparePart): void
    {
        if (!$this->spareParts->contains($sparePart))
        {
            $this->spareParts->add($sparePart);
        }
    }

    public function removeSparePart(SparePart $sparePart): void
    {
        $this->spareParts->remove($sparePart);
    }

    public function getAmountOfTimeSlots(): int
    {
        return $this->amountOfTimeSlots;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSpareParts(): Collection
    {
        return $this->spareParts;
    }

    public function setAmountOfTimeSlots(int $amountOfTimeSlots): void
    {
        $this->amountOfTimeSlots = $amountOfTimeSlots;
    }
}
