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

    public function saveFeedback(array $data)
    {
        $feedbackEntity = new Feedback();

        empty($data['title']) ? true : $feedbackEntity->setTitle($data['title']);

        $date   = DatetimeHelper::getCurrentDatetime();
        $author = empty($data['author']) ? Feedback::AUTHOR_GUEST : $data['author'];

        $feedbackEntity->setDate($date)
            ->setAuthor($author)
            ->setEmail($data['email'])
            ->setMessage($data['message']);

        try{
            $this->manager->persist($feedbackEntity);
            $this->manager->flush();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    public function findLastMessages(array $criteria, int $max = 0)
    {
        $gb = $this->createQueryBuilder('f');

        foreach($criteria as $index => $word) {
            $gb->orWhere("f.message NOT LIKE :msg$index")
                ->setParameter("msg$index", '%' . $word . '%');
        }

        if ($max > 0) {
            $gb->setMaxResults($max);
        }

        return $gb->orderBy('f.date', 'desc')
            ->getQuery()
            ->getResult();
    }
}
