<?php

namespace EvalBookCore\DataFixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use EvalBookCore\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class DevFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        // Adding admin user.
        $user = new User();

        $manager->flush();
    }

    /**
     * Set the fixtures group.
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['dev'];
    }
}
