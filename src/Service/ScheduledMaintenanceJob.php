<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Model;
use App\Entity\ScheduledMaintenanceJob as ScheduledMaintenanceJobEntity;
use App\Entity\SparePart;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ScheduledMaintenanceJob
{
    private HttpClientInterface $httpClient;
    private EntityManagerInterface $entityManager;

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager)
    {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
    }

    public function calculateCost(int $id, bool $useAPI = false): int
    {
        $scheduledMaintenanceJob = $this->entityManager->find(ScheduledMaintenanceJobEntity::class, $id);
        \assert($scheduledMaintenanceJob instanceof ScheduledMaintenanceJobEntity);

        $maintenanceJob = $scheduledMaintenanceJob->getMaintenanceJob();

        // Get the price for the work hours of the engineer
        $price = $maintenanceJob->getAmountOfTimeSlots() * $scheduledMaintenanceJob->getEngineer()->getWage();

        $weekday = date('w', $scheduledMaintenanceJob->getTimeSlot()->getUnixTimestamp());

        // Apply extra working costs on weekends (6 = Saturday, 0 = Sunday)
        if ($weekday === '6' || $weekday === '0') {
            $price = (int) ($price * 1.30);
        }

        if ($useAPI) {
            $price = $this->addSparePartPricesUsingApi(
                $maintenanceJob->getSpareParts(),
                $scheduledMaintenanceJob->getCar()->getModel(),
                $price
            );
        } else {
            $price = $this->addSparePartPricesUsingDatabase($maintenanceJob->getSpareParts(), $price);
        }

        // Apply VAT
        $price = (int) ($price * 1.21);

        return $price;
    }

    private function addSparePartPricesUsingApi(Collection $spareParts, Model $model, int $price): int
    {
        foreach ($spareParts as $sparePart) {
            \assert($sparePart instanceof SparePart);

            try {
                $response = $this->httpClient->request(
                    'GET',
                    'http://127.0.0.1:8000/spare_part/price',
                    [
                        'json' => [
                            "car_brand_name" => (string) $model->getBrand(),
                            "car_model_name" => $model->getName(),
                            "spare_part_name" => $sparePart->getName(),
                            "spare_part_brand_name" => (string) $sparePart->getBrand(),
                        ]
                    ]
                );

                $content = $response->toArray();
            } catch (\Throwable $e) {
                throw new \RuntimeException($e->getMessage());
            }

            \assert(array_key_exists('price', $content));
            $price += $content['price'];
        }

        return $price;
    }

    private function addSparePartPricesUsingDatabase(Collection $spareParts, int $price): int
    {
        foreach ($spareParts as $sparePart) {
            \assert($sparePart instanceof SparePart);
            $price += $sparePart->getPriceInCents();
        }

        return $price;
    }
}
