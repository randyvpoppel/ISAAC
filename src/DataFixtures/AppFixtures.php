<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Customer;
use App\Entity\Engineer;
use App\Entity\MaintenanceJob;
use App\Entity\Model;
use App\Entity\ScheduledMaintenanceJob;
use App\Entity\SparePart;
use App\Entity\TimeSlot;
use App\Value\CarBrand;
use App\Value\PartBrand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * Within these fixtures 2 instances of ScheduledMaintenanceJob are created.
     * Both instances contain the exact same car, mechanic and work to be done,
     * the only difference is that one maintenance job is scheduled during the weekend.
     */
    public function load(ObjectManager $manager)
    {
        $model = new Model(new CarBrand('Honda'), 'Civic');
        $manager->persist($model);

        $sparePart1 = new SparePart('Suspension Spring FL', 4520, new PartBrand('Bilstein'));
        $sparePart1->addModel($model);
        $manager->persist($sparePart1);

        $sparePart2 = new SparePart('Suspension Spring FR', 4520, new PartBrand('Bilstein'));
        $sparePart2->addModel($model);
        $manager->persist($sparePart2);

        $maintenanceJob = new MaintenanceJob(4, 'Front suspension job');
        $maintenanceJob->addSparePart($sparePart1);
        $maintenanceJob->addSparePart($sparePart2);
        $manager->persist($maintenanceJob);

        $customer = new Customer('Randy', 'van Poppel', '0648774886');
        $manager->persist($customer);

        $car = new Car('23-LN-DF', $model, $customer);
        $manager->persist($car);

        // Wed Feb 17 2021 09:00:00 GMT+0000
        $timeSlot1 = new TimeSlot(1613552400, 4);
        $manager->persist($timeSlot1);

        // Sat Feb 20 2021 09:00:00 GMT+0000
        $timeSlot2 = new TimeSlot(1613811600, 4);
        $manager->persist($timeSlot2);

        $engineer = new Engineer('Emile', 'Luijben', 1535);
        $manager->persist($engineer);

        $scheduledMaintenanceJob1 = new ScheduledMaintenanceJob($car, $engineer, $maintenanceJob, $timeSlot1);
        $manager->persist($scheduledMaintenanceJob1);

        $scheduledMaintenanceJob2 = new ScheduledMaintenanceJob($car, $engineer, $maintenanceJob, $timeSlot2);
        $manager->persist($scheduledMaintenanceJob2);

        $manager->flush();
    }
}
