<?php

// src/DataFixtures/AppFixtures.php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    const USER_REFERENCE = 'first-user';

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('jdoe');
        $user->setEmail('john_doe@mail.com');
        $user->setFirstname('John');
        $user->setLastname('Doe');
        $user->setUpdatedAt(new \DateTime());

        $password = $this->encoder->encodePassword($user, '11235');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}