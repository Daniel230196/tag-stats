<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Spi\TagRepositoryInterface;
use App\Domain\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * @extends ServiceEntityRepository<Tag>
 *
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository implements TagRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($registry, Tag::class);
    }

    public function getTagsStatistic(string $tagType, \DateTime $startDate, \DateTime $endDate): array
    {
        $connection = $this->getEntityManager()->getConnection();
        $sql = "SELECT
    AVG_score, MIN_score, STDDEV_score,
    ROUND(((AVG_score - MIN_score) / STDDEV_score), 2) AS complexity_index
FROM (
         SELECT
             AVG(score) AS AVG_score,
             MIN(score) AS MIN_score
         FROM tags where type=:type and created_at between :startDate and :endDate
     ) AS subquery,
     (
         SELECT
             type,
             SUM(POWER(score - AVG_score, 2)) as x1,
             COUNT(score) as cnt,
             ROUND(SQRT(SUM(POWER(score - AVG_score, 2)) / COUNT(score)), 2) AS STDDEV_score
         FROM tags join ((SELECT round(AVG(score), 2) AS AVG_score FROM tags where type=:type and created_at between :startDate and :endDate)) x where type =:type  and created_at between :startDate and :endDate
     ) AS stddev_subquery;";
        $stmt = $connection->prepare($sql);
        return $stmt->executeQuery([
            'type' => $tagType,
            'startDate' => $startDate->format('Y-m-d H:i:s'),
            'endDate' => $endDate->format('Y-m-d H:i:s'),
        ])->fetchAllAssociativeIndexed();
    }

    public function findByUuid(string $uuid): ?Tag
    {
        return $this->findOneBy(['uuid' => $uuid]);
    }

    public function save(Tag $tag): void
    {
        try {
            $this->getEntityManager()->persist($tag);
            $this->getEntityManager()->flush();
        } catch (\Throwable $t) {
            $this->logger->error('Ошибка сохранения команды', ['previous_exception' => $t]);
            throw $t;
        }
    }
}
