<?php

namespace App\DataFixtures;

use App\Entity\Workshop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WorkshopFixtures extends Fixture
{
    public const NBWORKSHOP = 5;

    public function load(ObjectManager $manager): void
    {
        for($i=1; $i<=self::NBWORKSHOP; $i++)
        {
        $workshop = new Workshop();
        $workshop->setTitleFr("Voyage au centre de mon image");
        $workshop->setDescription("");
        $workshop->setPicture("fixture-workshop.png");
        $workshop->setSmallPicture("fixture-workshop-small.jpg");
        $workshop->setDuration("3 heures");
        $workshop->setMinNbPlaces("5");
        $workshop->setMaxNbPlaces("10");
        $workshop->setLocation("tallinn");
        $workshop->setOptionalDescription("Si vous souhaitez organiser un atelier pour votre groupe, 
            faites-le moi savoir et nous trouverons une date qui vous convient.
            
            Durée: environ 3 heures.
            
            Lieu: dans les locaux de Fabimage au centre ville de Tallinn à 5 minutes à pied de la place Vabaduse.
            
            Nombre de participants: 5 à 15 pers.
            
            Animateur: Fabienne Chmara / coach en image
            
            Inscription: remplir et envoyer le formulaire au moins deux jours avant la date prévue pour l'atelier
            
            Tarif: 31 € / pers.
            
            COVID-Participation en toute sécurité !
            
            Toutes les conditions sont garanties pour une participation en toute sécurité : nombre limité de participants 
            et une grande salle équipée d'un système de ventilation performant.");
        $this->addReference('workshop_' . $i, $workshop);
        $manager->persist($workshop);
        }
        $manager->flush();
    }
}
