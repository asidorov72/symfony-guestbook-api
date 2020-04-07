<?php

namespace App\Repository;

use App\Entity\Feedback;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Helpers\DatetimeHelper;

/**
 * @method Feedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feedback[]    findAll()
 * @method Feedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct
    (
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Feedback::class);
        $this->manager = $manager;
    }

    public function saveFeedback(array $data) : bool
    {
        $feedbackEntity = new Feedback();

        empty($data['title']) ? true : $feedbackEntity->setTitle($data['title']);
        empty($data['email']) ? true : $feedbackEntity->setEmail($data['email']);

        $date   = DatetimeHelper::getCurrentDatetime();
        $author = empty($data['author']) ? Feedback::AUTHOR_GUEST : $data['author'];

        $feedbackEntity->setDate($date)
            ->setAuthor($author)
            ->setMessage($data['message']);

        try{
            $this->manager->persist($feedbackEntity);
            $this->manager->flush();
            return true;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    public function findMessages(array $criteria) : array
    {
        if (empty($criteria['exclude'])) {
            return $this->findAll();
        }

        $gb = $this->createQueryBuilder('f');

        foreach($criteria['exclude'] as $index => $word) {
            $gb->andWhere("f.message NOT LIKE :msg$index")
                ->setParameter("msg$index", '%' . $word . '%');
        }

        ($criteria['limit'] === 0) ? true : $gb->setMaxResults($criteria['limit']);

        $gb->orderBy( 'f.' . $criteria['orderBy']['field'], $criteria['orderBy']['order']);

        try {
            return $gb->getQuery()
                ->getResult();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }
}
