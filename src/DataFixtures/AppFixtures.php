<?php

namespace App\DataFixtures;


use DateTime;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    /* public function load(ObjectManager $manager)
    {
        $damien = new User();
        $damien->setMail("damien.nicolleau2019@campus-eni.fr");
        $damien->setNom("Nicolleau");
        $damien->setPrenom('Damien');
        $hash = $this->passwordEncoder->encodePassword($damien, '1234');
        $damien->setPassword($hash);
        $damien->setRoles(["ROLE_ADMIN"]);
        $date = date_create('2000-01-01');
        echo $date->format('Y-m-d H:i:s');
        $damien->setDateDeNaissance($date);

        $manager->persist($damien);
    }*/
    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        // TODO: Implement load() method.
    }
}
