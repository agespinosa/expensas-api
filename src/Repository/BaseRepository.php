<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

abstract class BaseRepository
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @var ObjectRepository
     */
    protected $objectRepository;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
        $this->objectRepository = $this->getEntityManager()->getRepository($this->entityClass());
    }

    abstract protected static function entityClass(): string;

    protected function saveEntity($entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    protected function removeEntity($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    protected function createQueryBuilder()
    {
        return $this->getEntityManager()->createQueryBuilder();
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|EntityManagerInterface
     */
    private function getEntityManager()
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->managerRegistry->getManager();

        if ($entityManager->isOpen()) {
            return $entityManager;
        }

        return $this->managerRegistry->resetManager();
    }
}
