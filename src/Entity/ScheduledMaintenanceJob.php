<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
final class ScheduledMaintenanceJob
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Car")
     * @ORM\JoinColumn(name="car_number_plate", referencedColumnName="number_plate")
     */
    private Car $car;

    /**
     * @ORM\ManyToOne(targetEntity="Engineer")
     * @ORM\JoinColumn(name="engineer_id", referencedColumnName="id")
     */
    private Engineer $engineer;

    /**
     * @ORM\ManyToOne(targetEntity="MaintenanceJob")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     */
    private MaintenanceJob $maintenanceJob;

    /**
     * @ORM\ManyToOne(targetEntity="TimeSlot")
     * @ORM\JoinColumn(name="time_slot_id", referencedColumnName="id")
     */
    private TimeSlot $timeSlot;

    public function __construct(Car $car, Engineer $engineer, MaintenanceJob $maintenanceJob, TimeSlot $timeSlot)
    {
        $this->car = $car;
        $this->engineer = $engineer;
        $this->maintenanceJob = $maintenanceJob;
        $this->timeSlot = $timeSlot;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCar(): Car
    {
        return $this->car;
    }

    public function getEngineer(): Engineer
    {
        return $this->engineer;
    }

    public function getMaintenanceJob(): MaintenanceJob
    {
        return $this->maintenanceJob;
    }

    public function getTimeSlot(): TimeSlot
    {
        return $this->timeSlot;
    }

    public function setEngineer(Engineer $engineer): void
    {
        $this->engineer = $engineer;
    }

    public function setMaintenanceJob(MaintenanceJob $maintenanceJob): void
    {
        $this->maintenanceJob = $maintenanceJob;
    }

    public function setTimeSlot(TimeSlot $timeSlot): void
    {
        $this->timeSlot = $timeSlot;
    }
}
