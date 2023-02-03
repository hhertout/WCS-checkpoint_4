<?php

namespace App\DataFixtures;

use App\Entity\PointOfInterest;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PointOfInterestFixtures extends Fixture implements DependentFixtureInterface
{
    public const POI_NB = 3;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < HikeFixtures::HIKE_NB; $i++) {
            for ($j = 0; $j < self::POI_NB; $j++) {
                $poi = new PointOfInterest();
                $poi->setTitle($faker->sentence());
                $poi->setDescription($faker->paragraph());
                $poi->addHike($this->getReference("hike_" . $i));

                $manager->persist($poi);
            }
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            HikeFixtures::class
        ];
    }
}
