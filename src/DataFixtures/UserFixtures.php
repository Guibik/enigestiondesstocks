<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('gg@eni.fr');
        $user->setPassword($this->encoder->encodePassword($user, 'admin'));
        $user->setLastName('Grandval');
        $user->setFirstName('Guillaume');
        $user->setPhone('0618876154');
        $user->setFunction('Dev');
        $manager->persist($user);
        $manager->flush();
    }
}