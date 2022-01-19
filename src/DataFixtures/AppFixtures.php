<?php

namespace EvalBookCore\DataFixtures;

use EvalBookCore\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Adding admin user.
        $user = new User();

        $manager->flush();
    }
}
