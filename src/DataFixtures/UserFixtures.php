<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    public const USER_NB = 20;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $user = new User();
        $user->setUsername('admin');
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setEmail("admin@hapy.fr");

        $password = $this->hasher->hashPassword($user, 'admin');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();

        for ($i = 0; $i < self::USER_NB; $i++) {
            $user = new User();
            $user->setEmail("visitor" . $i . "@gmail.com");
            $password = $this->hasher->hashPassword($user, 'password');
            $user->setPassword($password);
            $user->setRoles(["ROLE_USER"]);
            $user->setUsername($faker->userName());

            $this->addReference("user_" . $i, $user);

            $manager->persist($user);
        }
        $manager->flush();
    }
}
