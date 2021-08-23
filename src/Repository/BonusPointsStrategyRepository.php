<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusBonusPointsPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class BonusPointsStrategyRepository extends EntityRepository implements BonusPointsStrategyRepositoryInterface
{
    public function findAllActive(): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.enabled = true')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findActiveByCalculatorType(string $calculatorType): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.enabled = true')
            ->andWhere('o.calculatorType = :calculatorType')
            ->setParameter('calculatorType', $calculatorType)
            ->getQuery()
            ->getResult()
        ;
    }
}
