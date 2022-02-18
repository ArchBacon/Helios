<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Model\MessageModel;
use App\Factory\MessageFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 15; $i++)
        {
            $company = $faker->company();

            for ($j = 0; $j < 30; $j++) {
                $message = new MessageModel();
                $message->setCompany($company);
                $message->setUsername($faker->name());
                $message->setEmail($faker->email());
                $message->setMessage($faker->text());

                $manager->persist(MessageFactory::create($message));
            }
        }

        $manager->flush();
    }
}
