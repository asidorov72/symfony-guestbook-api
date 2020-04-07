<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Feedback;
use App\Helpers\DatetimeHelper;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $feedback = new Feedback();
            $feedback->setDate(
                $faker->dateTime('now', DatetimeHelper::LOCAL_TIMEZONE)->format('Y-m-d H:i:s')
            );
            $feedback->setAuthor($faker->firstName . ' ' . $faker->lastName);
            $feedback->setEmail($faker->email);
            $feedback->setTitle($faker->title);
            $feedback->setMessage($faker->text(1000));
            $manager->persist($feedback);
        }

        $manager->flush();
    }
}
