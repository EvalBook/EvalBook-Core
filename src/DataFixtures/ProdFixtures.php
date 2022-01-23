<?php

namespace EvalBookCore\DataFixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Error;
use EvalBookCore\Entity\Role;
use EvalBookCore\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class ProdFixtures extends Fixture implements FixtureGroupInterface
{
    private UserPasswordHasherInterface $pHasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->pHasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {

        $email = 'admin@evalbook.be';
        $password = 'adminADMIN0';

        // Production environment only need an administrator.
        $role = (new Role())->setName('ROLE_ADMIN');
        $user = (new User())
            ->setEmail($email)
            ->setFirstName('super')
            ->setLastName('admin')
            ->setRole($role)
        ;

        $user->setPassword($this->pHasher->hashPassword($user, $password));
        $manager->persist($user);
        $manager->flush();

        putenv("admin_password");
        putenv("admin_email");
    }

    /**
     * Set the fixtures group.
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['prod'];
    }
}
