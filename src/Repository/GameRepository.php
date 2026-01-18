<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Purchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findAvailableGamesOrderedByDate(): array
    {
        return $this->createQueryBuilder('g')
            ->leftJoin(
                Purchase::class,
                'p',
                'WITH',
                'p.game = g'
            )
            ->andWhere('p.id IS NULL')
            ->orderBy('g.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAvailableGamesFiltered(
        ?int $genreId = null,
        ?\DateTimeInterface $dateFrom = null,
        ?\DateTimeInterface $dateTo = null,
        ?string $search = null
    ): array {
        $qb = $this->createQueryBuilder('g')
            ->leftJoin(Purchase::class, 'p', 'WITH', 'p.game = g')
            ->andWhere('p.id IS NULL') // solo juegos no vendidos
            ->orderBy('g.createdAt', 'DESC');

        // Filtrar por género si existe
        if ($genreId) {
            $qb->join('g.genres', 'gen')
                ->andWhere('gen.id = :genreId')
                ->setParameter('genreId', $genreId);
        }

        // Filtrar por fecha desde
        if ($dateFrom) {
            $qb->andWhere('g.createdAt >= :dateFrom')
                ->setParameter('dateFrom', $dateFrom);
        }

        // Filtrar por fecha hasta
        if ($dateTo) {
            $qb->andWhere('g.createdAt <= :dateTo')
                ->setParameter('dateTo', $dateTo);
        }

        // Búsqueda por título o descripción
        if ($search) {
            $qb->andWhere('LOWER(g.title) LIKE :search OR LOWER(g.description) LIKE :search')
                ->setParameter('search', '%' . strtolower($search) . '%');
        }

        return $qb->getQuery()->getResult();
    }


    //    /**
    //     * @return Game[] Returns an array of Game objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Game
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
