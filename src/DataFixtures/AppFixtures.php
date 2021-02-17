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
     * Load fixtures.
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        $this->loadAdmin($manager);
        $this->loadUsers($manager);
    }

    /**
     * Load admin user.
     * @param ObjectManager $manager
     */
    public function loadAdmin(ObjectManager $manager) {
        $user = new User();
        $user->setEmail('admin@eb.com')
             ->setPassword($this->passwordEncoder->encodePassword($user, 'password'))
             ->setFirstname('Admin')
             ->setLastname('Super')
        ;
        $manager->persist($user);
        $manager->flush();
    }


    /**
     * Load classic users.
     * @param ObjectManager $manager
     */
    public function loadUsers(ObjectManager $manager) {
        for($i = 5; $i > 0; $i--) {
            $user = new User();
            $user->setEmail('u-' . $i . '@eb.com')
                 ->setPassword($this->passwordEncoder->encodePassword($user, 'password'))
                 ->setFirstname('User')
                 ->setLastname($i)
            ;
            $manager->persist($user);
        }
        $manager->flush();
    }
}
