<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    )
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN'])
            ->setEmail('admin@doe.fr')
            ->setFirstName('john')
            ->setName('Doe')
            ->setDeliveryAddress('1 avenue Foch')
            ->setPassword($this->hasher->hashPassword($user, 'admin'));
        $manager->persist($user);
        
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
