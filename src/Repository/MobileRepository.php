<?php

namespace App\Repository;

use App\Entity\Mobile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Mobile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mobile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mobile[]    findAll()
 * @method Mobile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MobileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mobile::class);
    }
}
