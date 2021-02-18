<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Model as ModelEntity;
use App\Entity\SparePart as SparePartEntity;
use App\Value\CarBrand;
use App\Value\PartBrand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

final class SparePart
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByNameBrandModelNameAndCarBrand(string $name, PartBrand $partBrand, string $modelName, CarBrand $carBrand): SparePartEntity
    {
        try {
            return
                $this->entityManager
                    ->createQueryBuilder()
                    ->select('s')
                    ->from(SparePartEntity::class, 's')
                    ->join(ModelEntity::class, 'm')
                    ->where('s.name = ?1')
                    ->andWhere('s.brand = ?2')
                    ->andWhere('m.name = ?3')
                    ->andWhere('m.brand = ?4')
                    ->setParameter(1, $name)
                    ->setParameter(2, (string) $partBrand)
                    ->setParameter(3, $modelName)
                    ->setParameter(4, (string) $carBrand)
                    ->getQuery()
                    ->getSingleResult();
        } catch (NoResultException $e) {
            throw new \RuntimeException('Part not found', 404);
        } catch (NonUniqueResultException $e) {
            throw new \RuntimeException('Multiple parts found for given criteria', 500);
        }
    }
}
