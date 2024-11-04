<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $blackbelt = new Product;
        $blackbelt->setName('Blackbelt')
            ->setImage('1-67275335ca8a6.jpg')
            ->setPrice(29.9)
            ->setSize('S')
            ->setStock(2);
        $manager->persist($blackbelt);
        $manager->flush();

        $bluebelt = new Product;
        $bluebelt->setName('BlueBelt')
            ->setImage('2-672753a3dbc38.jpg')
            ->setPrice(29.9)
            ->setSize('S')
            ->setStock(2);
        $manager->persist($bluebelt);
        $manager->flush();

        $street = new Product;
        $street->setName('Street')
            ->setImage('3-672753c8949be.jpg')
            ->setPrice(34.5)
            ->setSize('S')
            ->setStock(2);
        $manager->persist($street);
        $manager->flush();

        $pokeball = new Product;
        $pokeball->setName('Pokeball')
            ->setImage('4-672753e462496.jpg')
            ->setPrice(45)
            ->setSize('S')
            ->setStock(2);
        $manager->persist($pokeball);
        $manager->flush();

        $pinklady = new Product;
        $pinklady->setName('PinkLady')
            ->setImage('5-6727546469e75.jpg')
            ->setPrice(29.9)
            ->setSize('S')
            ->setStock(2);
        $manager->persist($pinklady);
        $manager->flush();

        $snow = new Product;
        $snow->setName('Snow')
            ->setImage('6-672754b8e1a43.jpg')
            ->setPrice(32)
            ->setSize('S')
            ->setStock(2);
        $manager->persist($snow);
        $manager->flush();

        $greyback = new Product;
        $greyback->setName('Greyback')
            ->setImage('7-672754d776f14.jpg')
            ->setPrice(28.5)
            ->setSize('S')
            ->setStock(2);
        $manager->persist($greyback);
        $manager->flush();

        $bluecloud = new Product;
        $bluecloud->setName('BlueCloud')
            ->setImage('8-672754ee199b1.jpg')
            ->setPrice(45)
            ->setSize('S')
            ->setStock(2);
        $manager->persist($bluecloud);
        $manager->flush();

        $borninusa = new Product;
        $borninusa->setName('BorninUsa')
            ->setImage('9-672755092fa4e.jpg')
            ->setPrice(59.9)
            ->setSize('S')
            ->setStock(2);
        $manager->persist($borninusa);
        $manager->flush();

        $greenschool = new Product;
        $greenschool->setName('GreenSchool')
            ->setImage('10-672755255bdba.jpg')
            ->setPrice(42.2)
            ->setSize('S')
            ->setStock(2);
        $manager->persist($greenschool);
        $manager->flush();
    }
}
