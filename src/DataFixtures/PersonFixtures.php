<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $person = new Person();
            $person->setFirstName(sprintf('Prenom %d', $i));
            $person->setLastName(sprintf('Nom %d', $i));

            $manager->persist($person);
        }

        $manager->flush();
    }
}
