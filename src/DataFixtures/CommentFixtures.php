<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Comment;
use App\DataFixtures\HikeFixtures;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public const COMMENT_NB = 3;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < UserFixtures::USER_NB; $i++) {
            for ($j = 0; $j < self::COMMENT_NB; $j++) {
                $comment = new Comment();
                $date = new DateTime();
                $comment->setCreationDate($date);
                $comment->setComment($faker->paragraph(3));
                $comment->setRate(rand(3, 5));
                $comment->setUser($this->getReference("user_" . $i));
                $comment->setHikes($this->getReference("hike_" . rand(0, (HikeFixtures::HIKE_NB - 1))));

                $manager->persist($comment);
            }
        }


        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            HikeFixtures::class,
            UserFixtures::class,
        ];
    }
}
