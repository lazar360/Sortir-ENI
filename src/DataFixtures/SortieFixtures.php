<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SortieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $etatCree = new Etat();
        $etatCree->setLibelle("créée");
        $manager->persist($etatCree);

        $etatPubliee = new Etat();
        $etatPubliee->setLibelle("publiée");
        $manager->persist($etatPubliee);

        $etatCloturee = new Etat();
        $etatCloturee->setLibelle("clôturée");
        $manager->persist($etatCloturee);

        $etatEnCours = new Etat();
        $etatEnCours->setLibelle("en cours");
        $manager->persist($etatEnCours);

        $etatArchivee = new Etat();
        $etatArchivee->setLibelle("archivée");
        $manager->persist($etatArchivee);

        $manager->flush();
    }
}
