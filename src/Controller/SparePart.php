<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\SparePart as SparePartRepository;
use App\Value\CarBrand;
use App\Value\PartBrand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SparePart
{
    private static array $keys = [
        "car_brand_name",
        "car_model_name",
        "spare_part_name",
        "spare_part_brand_name",
    ];

    private SparePartRepository $sparePartRepository;

    public function __construct(SparePartRepository $sparePartRepository)
    {
        $this->sparePartRepository = $sparePartRepository;
    }

    /**
     * @Route("/spare_part/price", name="app_spare_part_price")
     */
    public function getSparePartPrice(Request $request): Response
    {
        try {
            $parameters = \json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return new JsonResponse(
                ['error' => 'Invalid argument given: Argument needs to be JSON'],
                422
            );
        }

        foreach (self::$keys as $key) {
            if (!array_key_exists($key, $parameters)) {
                return new JsonResponse(
                    ['error' => 'Invalid argument given: Missing key: ' . $key],
                    422
                );
            }
        }

        try {
            return new JsonResponse(
                [
                    'price' => $this->sparePartRepository->findByNameBrandModelNameAndCarBrand(
                        $parameters['spare_part_name'],
                        new PartBrand($parameters['spare_part_brand_name']),
                        $parameters['car_model_name'],
                        new CarBrand($parameters['car_brand_name']))
                        ->getPriceInCents()
                ]
            );
        } catch (\Throwable $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                $e->getCode()
            );
        }
    }
}
