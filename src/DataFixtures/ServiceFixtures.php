<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ServiceFixtures extends Fixture
{
    public const NBSERVICES = 5;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($i=1; $i<=self::NBSERVICES; $i++)
        {
            $service = new Service();
            $service->setTitle('Colorimétrie');
            $service->setUnderTitle('La couleur est un des moyens d’expression les plus importants pour un artiste. Et s’habiller est un art!  ');
            $service->setPicture('fixture-service.png');
            $service->setDescription('La couleur est un des moyens d’expression les plus importants pour un artiste.<br>Et s’habiller est un art !<br><br>Une des premières choses que nous remarquons (même inconsciemment) dans l’habillement d’une personne c’est la couleur. Vous pouvez aussi utiliser les couleurs pour faire passer des messages qui vous aideront à vous sentir plus sur de vous-même dans différentes situations.<br><br>En effet, nos émotions sont aussi en couleur! C’est pourquoi lors de notre rendez-vous nous commencerons par l’observation de votre état chromatique interne, c’est à dire par détecter <strong>les couleurs de vos émotions !</strong> Sur cette base nous choisirons les premières deux ou trois couleurs avec lesquelles vous souhaitez travailler au <strong>niveau émotionnel.</strong><br><br>Ensuite nous parlerons des bases de la colorimétrie : classification et harmonie des couleurs. Nous découvrirons <strong>„vos couleurs“,</strong> celles qui vous mettent en lumière, cette fois-ci au niveau physiologique. Les couleurs appropriées à votre carnation font ressortir vos yeux, la couleur de vos cheveux et illuminent votre teint. Lorsque vous portez ces couleurs on vous remarque plus que le vêtement.<br><br>En somme <strong>nous mettrons les couleurs à VOTRE service!</strong><br><br>1 séance de 2 h');
            $service->setSmallPicture('fixture-service-small.png');
            $service->setVerticalPicture('fixture-service-vertical.png');
            $manager->persist($service);
        }
        $manager->flush();
    }
}
