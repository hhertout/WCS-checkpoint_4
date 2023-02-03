<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Hike;
use App\DataFixtures\LocationFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class HikeFixtures extends Fixture implements DependentFixtureInterface
{
    public const HIKE_NB = 15;
    public const HIKE_TYPE = ["Alpinisme", "Randonnée", "Familiale"];
    public const HIKE_SEASON = ["summer", "winter"];
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        for ($i = 0; $i < self::HIKE_NB; $i++) {
            $hike = new Hike();
            $title = $faker->sentence();
            $hike->setTitle($title);
            $hike->setSlug($this->slugger->slug($title));
            $hike->setDescription($faker->paragraphs(rand(1,5), true));
            $hike->setElevation(rand(100, 1400));
            $hike->setShort($faker->sentence());
            $hike->setRoute($faker->paragraphs(10, true));
            $hike->setDifficulty(rand(1, 5));
            $hike->setDistance(20);
            $hike->setSeason(self::HIKE_SEASON[rand(0, 1)]);
            $hike->setLocation($this->getReference("location_" . rand(0, count(LocationFixtures::LOCATION) - 1 )));
            $hike->setType(self::HIKE_TYPE[rand(0, 2)]);
            $this->addReference("hike_" . $i, $hike);

            $manager->persist($hike);

            $manager->flush();
        }
    }
    public function getDependencies()
    {
        return [
            LocationFixtures::class,
        ];
    }
}
