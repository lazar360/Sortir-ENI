<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class ParticipantFixtures extends Fixture
{

    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {

        $this->hasher = $hasher;

    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 4; $i++) {
            $site = new Site();
            $site->setNomSite("site numero $i");

            $manager->persist($site);

        }

        $participantAdmin = new Participant();
        $siteAdmin = new Site();
        $siteAdmin->setNomSite("Site administrateur");
        $password = $this->hasher->hashPassword($participantAdmin, "password");


        $participantAdmin
            ->setUsername("admin")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($password)
            ->setNom("admin")
            ->setPrenom("admin")
            ->setTelephone("0625548746")
            ->setMail("admin@gmail.com")
            ->setAdministrateur(true)
            ->setActif(true)
            ->setSite($siteAdmin)
            ->setPicture(null);

        $manager->persist($participantAdmin);

        $manager->flush();
    }
}