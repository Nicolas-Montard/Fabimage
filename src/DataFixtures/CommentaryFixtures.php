<?php

namespace App\DataFixtures;

use App\Entity\Commentary;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentaryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($w=1; $w<=WorkshopFixtures::NBWORKSHOP; $w++)
        {
            for ($i=1; $i<=5; $i++){
                $commentary = new Commentary();
                $commentary->setWorkshop($this->getReference('workshop_' . $w));
                $commentary->setContent($faker->paragraphs(3, true));
                $commentary->setAuthor($faker->name());
                $manager->persist($commentary);
            }

        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            WorkshopFixtures::class
        ];
    }
}
