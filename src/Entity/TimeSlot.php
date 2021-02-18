<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @final
 *
 * @ORM\Entity()
 */
class TimeSlot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer", length=10)
     */
    private int $unixTimestamp;

    /**
     * Each time slot is 15 minutes
     * @ORM\Column(type="integer")
     */
    private int $amountOfTimeSlots;

    public function __construct(int $unixTimestamp, int $amountOfTimeSlots)
    {
        $this->unixTimestamp = $unixTimestamp;
        $this->amountOfTimeSlots = $amountOfTimeSlots;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUnixTimestamp(): int
    {
        return $this->unixTimestamp;
    }

    public function getAmountOfTimeSlots(): int
    {
        return $this->amountOfTimeSlots;
    }
}
