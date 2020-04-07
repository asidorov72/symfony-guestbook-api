<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6.4.2020 г.
 * Time: 19:34
 */

namespace App\Tests\Repository;

use App\Entity\Feedback;
use App\Services\FeedbackShowService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FeedbackRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testFindMessagesCorrectCreteria()
    {
        $feedbackList = $this->entityManager
            ->getRepository(Feedback::class)
            ->findMessages(
                [
                    'exclude' => FeedbackShowService::EXCLUDE_WORDS_ARRAY,
                    'orderBy' => ['field' => 'date', 'order' => 'desc'],
                    'limit' => 10
                ]
            );

        $this->assertGreaterThan(1, $feedbackList);
    }

    public function testFindMessagesNoCreteria()
    {
        $feedbackList = $this->entityManager
            ->getRepository(Feedback::class)
            ->findMessages([]);

        $this->assertGreaterThan(1, $feedbackList);
    }

    public function testSaveFeedback()
    {
        $pathToFile  = __DIR__ . "/../../tests/testing/json/add_feedback_payload.json";
        $payloadJson = file_get_contents($pathToFile);
        $payload     = json_decode($payloadJson, true);

        $res = $feedbackList = $this->entityManager
            ->getRepository(Feedback::class)
            ->saveFeedback($payload);

        $this->assertTrue($res);
    }



    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}