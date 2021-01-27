<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $pInterface
     */
    public function __construct(UserPasswordEncoderInterface $pInterface){
        $this->passwordEncoder = $pInterface;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setEmail('admin@eb.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));

        $manager->persist($user);
        $manager->flush();
    }
}
