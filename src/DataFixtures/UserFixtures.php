<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private object $hasher;

    private array $genders = ['male', 'female'];

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 30; $i++) {
            $user = new User();
            $gender = $faker->randomElement($this->genders);
            $user->setFirstName($faker->firstName($gender))
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setPassword($this->hasher->hashPassword($user, 'password'))
                ->setRoles(['ROLE_USER'])
                ->setDisabled($faker->boolean(5))
                ->setVerified(true);
            $gender = ($gender == 'male') ? 'm' : 'f';
            $user->setImage('0' . ($i + 10) . $gender . '.jpg');
            $manager->persist($user);
        }




        $admin = new User();
        $gender = $faker->randomElement($this->genders);
        $admin->setFirstName('Admin')
            ->setLastName('Smeers')
            ->setEmail('ad@min.be')
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setPassword($this->hasher->hashPassword($admin, 'password'))
            ->setRoles(['ROLE_ADMIN'])
            ->setDisabled(false)
            ->setVerified(true);
        $gender = ($gender == 'male') ? 'm' : 'f';
        $admin->setImage('075' . $gender . '.jpg');
        $manager->persist($admin);

        $user = new User();
        $gender = $faker->randomElement($this->genders);
        $user->setFirstName('User')
            ->setLastName('Smeers')
            ->setEmail('us@er.be')
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setPassword($this->hasher->hashPassword($user, 'password'))
            ->setRoles(['ROLE_USER'])
            ->setDisabled(false)
            ->setVerified(true);
        $gender = ($gender == 'male') ? 'm' : 'f';
        $user->setImage('076' . $gender . '.jpg');
        $manager->persist($user);
        $manager->flush();
    }

}