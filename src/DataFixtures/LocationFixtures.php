<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Location;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LocationFixtures extends Fixture
{
    public const LOCATION = [
        [
            "city" => "Col du Tourmalet",
            "valley" => "Tourmalet",
            "lat" => 42.908577,
            "long" => 0.145486,
        ],
        [
            "city" => "Col du Soulor",
            "valley" => "Val d'Azun",
            "lat" => 42.960663,
            "long" => -0.261636,
        ],
        [
            "city" => "Bagnères de Bigorre",
            "valley" => "Tourmalet",
            "lat" => 43.065779,
            "long" => 0.149362,
        ],
        [
            "city" => "Lourdes",
            "valley" => "Vallée des Gaves",
            "lat" => 43.090944,
            "long" => -0.046879,
        ],
        [
            "city" => "Luz-Saint_sauver",
            "valley" => "Vallée de Luz",
            "lat" => 42.83121,
            "long" => -0.003282,
        ],
        [
            "city" => "Gavarnie",
            "valley" => "Gavarnie",
            "lat" => 42.785644,
            "long" => 0.020595,
        ],
        [
            "city" => "Cirque de Troumousse",
            "valley" => "Troumousse",
            "lat" => 42.727963,
            "long" => 0.095429,
        ],
        [
            "city" => "Lac d'Aubert",
            "valley" => "Route des Lacs",
            "lat" => 42.840221,
            "long" => 0.144082,
        ],
        [
            "city" => "Pont d'Espagne",
            "valley" => "Vallée de Cauterêt",
            "lat" => 42.852102,
            "long" => -0.135744,
        ],
        [
            "city" => "Estaing",
            "valley" => "Val d'Azun",
            "lat" => 42.904855,
            "long" => -0.211439,
        ],
        [
            "city" => "Loudenvielle",
            "valley" => "Val Louron",
            "lat" => 42.802686,
            "long" => 0.4141051,
        ],
        [
            "city" => "Ôo",
            "valley" => "Luchonnais",
            "lat" => 42.763843,
            "long" => 0.501694,
        ],


    ];
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < count(self::LOCATION); $i++) {
            $location = new Location();
            $location->setCity(self::LOCATION[$i]["city"]);
            $location->setValley(self::LOCATION[$i]["valley"]);
            $location->setLatitude(self::LOCATION[$i]["lat"]);
            $location->setLongitude(self::LOCATION[$i]["long"]);

            $this->addReference("location_" . $i, $location);

            $manager->persist($location);
        }

        $manager->flush();
    }
}
